<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\FabricInspection;
use App\Models\Grn;
use App\Models\GrnRoll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrnController extends Controller
{
    /* ===================== GRN INDEX ===================== */

    public function index(Request $request)
    {
        $query = Grn::with(['fabric'])->withCount('rolls');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('grn_number', 'like', "%{$s}%")
                  ->orWhere('invoice_number', 'like', "%{$s}%")
                  ->orWhere('supplier_name', 'like', "%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $grns = $query->latest()->paginate(15)->withQueryString();
        return view('grn.index', compact('grns'));
    }

    /* ===================== CREATE GRN ===================== */

    public function create()
    {
        $fabrics   = Fabric::where('status', 'active')->orderBy('fabric_code')->get();
        $grnNumber = Grn::nextNumber();
        return view('grn.create', compact('fabrics', 'grnNumber'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_number'    => 'required|string|max:100',
            'supplier_name'     => 'required|string|max:200',
            'fabric_id'         => 'required|exists:fabrics,id',
            'received_date'     => 'required|date',
            'rack_location'     => 'nullable|string|max:100',
            'remarks'           => 'nullable|string',
            // Rolls
            'rolls'             => 'required|array|min:1',
            'rolls.*.roll_number'  => 'required|string|max:50|distinct',
            'rolls.*.roll_weight'  => 'nullable|numeric|min:0',
            'rolls.*.roll_length'  => 'nullable|numeric|min:0',
            'rolls.*.actual_width' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($data) {
            $grn = Grn::create([
                'grn_number'     => Grn::nextNumber(),
                'invoice_number' => $data['invoice_number'],
                'supplier_name'  => $data['supplier_name'],
                'fabric_id'      => $data['fabric_id'],
                'received_date'  => $data['received_date'],
                'rack_location'  => $data['rack_location'] ?? null,
                'remarks'        => $data['remarks'] ?? null,
                'status'         => 'open',
            ]);

            foreach ($data['rolls'] as $rollData) {
                GrnRoll::create([
                    'grn_id'       => $grn->id,
                    'roll_number'  => $rollData['roll_number'],
                    'roll_weight'  => $rollData['roll_weight']  ?? null,
                    'roll_length'  => $rollData['roll_length']  ?? null,
                    'actual_width' => $rollData['actual_width'] ?? null,
                    'qr_code'      => GrnRoll::generateQrCode($grn->grn_number, $rollData['roll_number']),
                    'status'       => 'pending_inspection',
                ]);
            }
        });

        $grn = Grn::where('invoice_number', $data['invoice_number'])
                  ->where('supplier_name', $data['supplier_name'])
                  ->latest()->first();

        return redirect()->route('grn.show', $grn)
            ->with('success', "GRN {$grn->grn_number} created with {$grn->rollCount()} roll(s).");
    }

    /* ===================== SHOW GRN ===================== */

    public function show(Grn $grn)
    {
        $grn->load(['fabric', 'rolls.inspection']);
        return view('grn.show', compact('grn'));
    }

    /* ===================== QR LABEL PRINT ===================== */

    public function printLabels(Grn $grn)
    {
        $grn->load(['fabric', 'rolls']);
        return view('grn.print-labels', compact('grn'));
    }

    public function printSingleLabel(GrnRoll $roll)
    {
        $roll->load('grn.fabric');
        return view('grn.print-single-label', compact('roll'));
    }

    /* ===================== INSPECTION ===================== */

    public function inspectRoll(GrnRoll $roll)
    {
        if ($roll->inspection) {
            return redirect()->route('grn.show', $roll->grn_id)
                ->with('warning', "Roll {$roll->roll_number} has already been inspected.");
        }
        $roll->load('grn.fabric');
        return view('grn.inspect', compact('roll'));
    }

    public function storeInspection(Request $request, GrnRoll $roll)
    {
        $data = $request->validate([
            'inspected_by'    => 'required|string|max:100',
            'inspection_date' => 'required|date',
            'shade_result'    => 'required|in:OK,NG',
            'shade_notes'     => 'nullable|string',
            'shrinkage_warp'  => 'nullable|numeric|min:0|max:100',
            'shrinkage_weft'  => 'nullable|numeric|min:0|max:100',
            'width_result'    => 'nullable|numeric|min:0',
            'defects_found'   => 'required|integer|min:0',
            'pieces_inspected'=> 'required|integer|min:1',
            'overall_result'  => 'required|in:Pass,Fail,Conditional',
            'remarks'         => 'nullable|string',
        ]);

        $dhu = FabricInspection::calcDhu(
            (int) $data['defects_found'],
            (int) $data['pieces_inspected']
        );

        DB::transaction(function () use ($roll, $data, $dhu) {
            FabricInspection::create(array_merge($data, [
                'grn_roll_id' => $roll->id,
                'dhu_percent' => $dhu,
            ]));

            $newStatus = match ($data['overall_result']) {
                'Pass'        => 'in_stock',
                'Fail'        => 'rejected',
                'Conditional' => 'inspected',
            };
            $roll->update(['status' => $newStatus]);
        });

        return redirect()->route('grn.show', $roll->grn_id)
            ->with('success', "Roll {$roll->roll_number} inspected — Result: {$data['overall_result']}, DHU: {$dhu}%");
    }

    /* ===================== SCAN QR ===================== */

    public function scanQr(Request $request)
    {
        if ($request->filled('qr')) {
            $roll = GrnRoll::where('qr_code', $request->qr)->with('grn.fabric', 'inspection')->first();
            return view('grn.scan', compact('roll'));
        }
        return view('grn.scan', ['roll' => null]);
    }
}
