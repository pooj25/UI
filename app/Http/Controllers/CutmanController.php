<?php

namespace App\Http\Controllers;

use App\Models\CutOrder;
use App\Models\FabricReservation;
use App\Models\GrnRoll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CutmanController extends Controller
{
    public function index(Request $request)
    {
        $query = CutOrder::with(['layModel', 'fabricReservation']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('cut_order_no', 'like', "%{$s}%");
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cutOrders = $query->latest()->paginate(15)->withQueryString();
        return view('cutman.index', compact('cutOrders'));
    }

    public function create()
    {
        // Only reservations that have been issued can be cut
        $issuedReservations = FabricReservation::where('status', 'issued')
            ->with('layModel')
            ->orderByDesc('id')
            ->get();
        
        $cutOrderNo = CutOrder::nextNumber();

        return view('cutman.create', compact('issuedReservations', 'cutOrderNo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fabric_reservation_id' => 'required|exists:fabric_reservations,id',
            'planned_qty'           => 'required|integer|min:1',
            'planned_date'          => 'required|date',
            'remarks'               => 'nullable|string',
        ]);

        $reservation = FabricReservation::findOrFail($data['fabric_reservation_id']);

        if ($reservation->status !== 'issued') {
            return back()->with('error', 'Selected reservation is not in Issued state.');
        }

        if (!$reservation->lay_model_id) {
            return back()->with('error', 'Reservation must have a Lay Model attached to create a Cut Order.');
        }

        DB::transaction(function () use ($data, $reservation) {
            $cutOrder = CutOrder::create([
                'cut_order_no'          => CutOrder::nextNumber(),
                'fabric_reservation_id' => $reservation->id,
                'lay_model_id'          => $reservation->lay_model_id,
                'planned_qty'           => $data['planned_qty'],
                'planned_date'          => $data['planned_date'],
                'status'                => 'planned',
                'remarks'               => $data['remarks'] ?? null,
            ]);

            // Link all rolls from the reservation to the cut order with 0 usage initially
            foreach ($reservation->rolls as $roll) {
                $cutOrder->rolls()->attach($roll->id, [
                    'used_length' => null,
                    'used_weight' => null,
                ]);
            }
        });

        return redirect()->route('cutman.index')
            ->with('success', 'Cutting Order created successfully.');
    }

    public function show(CutOrder $cutman)
    {
        $cutman->load(['layModel', 'fabricReservation', 'rolls.grn.fabric']);
        return view('cutman.show', compact('cutman'));
    }

    public function start(CutOrder $cutman)
    {
        if ($cutman->status !== 'planned') {
            return back()->with('error', 'Only planned cut orders can be started.');
        }

        $cutman->update(['status' => 'cutting']);
        return back()->with('success', 'Cutting started. You can now scan rolls to record usage.');
    }

    public function complete(CutOrder $cutman)
    {
        if ($cutman->status !== 'cutting') {
            return back()->with('error', 'Only in-progress cut orders can be completed.');
        }

        $cutman->update(['status' => 'completed']);
        return back()->with('success', 'Cutting Order marked as completed.');
    }

    public function updateRollUsage(Request $request, CutOrder $cutman, GrnRoll $roll)
    {
        if ($cutman->status !== 'cutting') {
            return back()->with('error', 'Cannot update usage unless cutting is in progress.');
        }

        $data = $request->validate([
            'used_length' => 'nullable|numeric|min:0',
            'used_weight' => 'nullable|numeric|min:0',
        ]);

        $exists = $cutman->rolls()->where('grn_roll_id', $roll->id)->exists();
        if (!$exists) {
            return back()->with('error', 'This roll is not part of the current cutting order.');
        }

        $cutman->rolls()->updateExistingPivot($roll->id, [
            'used_length' => $data['used_length'],
            'used_weight' => $data['used_weight'],
        ]);

        return back()->with('success', "Usage recorded for roll {$roll->roll_number}.");
    }
}
