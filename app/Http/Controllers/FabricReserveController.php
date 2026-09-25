<?php

namespace App\Http\Controllers;

use App\Models\FabricReservation;
use App\Models\GrnRoll;
use App\Models\LayModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FabricReserveController extends Controller
{
    public function index(Request $request)
    {
        $query = FabricReservation::with(['layModel', 'rolls']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('reservation_no', 'like', "%{$s}%")
                  ->orWhere('requested_by', 'like', "%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->latest()->paginate(15)->withQueryString();
        return view('fabric-reserve.index', compact('reservations'));
    }

    public function create()
    {
        $layModels = LayModel::where('status', 'active')->orderBy('lay_model_code')->get();
        $reservationNo = FabricReservation::nextNumber();
        
        // Only show rolls that are in stock
        $availableRolls = GrnRoll::where('status', 'in_stock')
            ->with(['grn.fabric'])
            ->get()
            ->sortBy(function($r) {
                return $r->grn->fabric->fabric_code ?? '';
            });

        return view('fabric-reserve.create', compact('layModels', 'reservationNo', 'availableRolls'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lay_model_id' => 'nullable|exists:lay_models,id',
            'requested_by' => 'required|string|max:100',
            'request_date' => 'required|date',
            'remarks'      => 'nullable|string',
            'rolls'        => 'required|array|min:1',
            'rolls.*'      => 'exists:grn_rolls,id',
        ]);

        DB::transaction(function () use ($data) {
            $reservation = FabricReservation::create([
                'reservation_no' => FabricReservation::nextNumber(),
                'lay_model_id'   => $data['lay_model_id'] ?? null,
                'request_date'   => $data['request_date'],
                'requested_by'   => $data['requested_by'],
                'status'         => 'pending',
                'remarks'        => $data['remarks'] ?? null,
            ]);

            // Attach rolls
            $reservation->rolls()->attach($data['rolls']);
        });

        return redirect()->route('fabric-reserve.index')
            ->with('success', 'Fabric Reservation created successfully.');
    }

    public function show(FabricReservation $fabricReserve)
    {
        $fabricReserve->load(['layModel', 'rolls.grn.fabric']);
        return view('fabric-reserve.show', compact('fabricReserve'));
    }

    public function approve(FabricReservation $fabricReserve)
    {
        if ($fabricReserve->status !== 'pending') {
            return back()->with('error', 'Only pending reservations can be approved.');
        }

        DB::transaction(function () use ($fabricReserve) {
            $fabricReserve->update(['status' => 'approved']);
            // Update all attached rolls to 'reserved'
            GrnRoll::whereIn('id', $fabricReserve->rolls->pluck('id'))->update(['status' => 'reserved']);
        });

        return back()->with('success', 'Reservation approved. Rolls are now reserved.');
    }

    public function issue(FabricReservation $fabricReserve)
    {
        if ($fabricReserve->status !== 'approved') {
            return back()->with('error', 'Only approved reservations can be issued.');
        }

        DB::transaction(function () use ($fabricReserve) {
            $fabricReserve->update(['status' => 'issued']);
            // Update all attached rolls to 'issued'
            GrnRoll::whereIn('id', $fabricReserve->rolls->pluck('id'))->update(['status' => 'issued']);
        });

        return back()->with('success', 'Reservation issued to Cutting Department.');
    }
    
    public function cancel(FabricReservation $fabricReserve)
    {
        if (in_array($fabricReserve->status, ['issued', 'cancelled'])) {
            return back()->with('error', 'Cannot cancel an issued or already cancelled reservation.');
        }

        DB::transaction(function () use ($fabricReserve) {
            $fabricReserve->update(['status' => 'cancelled']);
            // If it was approved, we need to revert rolls back to in_stock
            GrnRoll::whereIn('id', $fabricReserve->rolls->pluck('id'))
                ->where('status', 'reserved')
                ->update(['status' => 'in_stock']);
        });

        return back()->with('success', 'Reservation cancelled.');
    }
}
