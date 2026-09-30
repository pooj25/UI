<?php

namespace App\Http\Controllers;

use App\Models\CutOrder;
use App\Models\PanelInspection;
use Illuminate\Http\Request;

class PanelInspectionController extends Controller
{
    public function index()
    {
        $inspections = PanelInspection::with('cutOrder')->latest()->get();
        return view('panel-inspection.index', compact('inspections'));
    }

    public function create()
    {
        // Get completed cut orders that haven't been fully inspected
        $cutOrders = CutOrder::where('status', 'completed')->get();
        return view('panel-inspection.create', compact('cutOrders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cut_order_id' => 'required|exists:cut_orders,id',
            'inspector_name' => 'required|string|max:100',
            'total_panels_checked' => 'required|integer|min:1',
            'panels_passed' => 'required|integer|min:0',
            'panels_rejected' => 'required|integer|min:0',
            'defect_reason' => 'nullable|string',
        ]);

        if (($request->panels_passed + $request->panels_rejected) != $request->total_panels_checked) {
            return back()->with('error', 'Passed + Rejected must equal Total Checked.');
        }

        PanelInspection::create($request->all());

        return redirect()->route('panel-inspection.index')->with('success', 'Inspection recorded successfully.');
    }
}
