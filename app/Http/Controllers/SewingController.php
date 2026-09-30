<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\SewingProduction;
use Illuminate\Http\Request;

class SewingController extends Controller
{
    public function index()
    {
        // Show recent sewing productions
        $productions = SewingProduction::with('bundle')->latest()->limit(100)->get();
        return view('sewing.index', compact('productions'));
    }

    public function scan()
    {
        return view('sewing.scan');
    }

    public function processScan(Request $request)
    {
        $request->validate([
            'bundle_no' => 'required|string',
        ]);

        $bundle = Bundle::where('bundle_no', $request->bundle_no)->first();

        if (!$bundle) {
            return redirect()->back()->with('error', 'Bundle not found.');
        }

        return view('sewing.process', compact('bundle'));
    }

    public function store(Request $request, Bundle $bundle)
    {
        $request->validate([
            'line_number'   => 'required|string',
            'operator_name' => 'required|string',
            'operation'     => 'required|string',
            'qty_passed'    => 'required|integer|min:0|max:' . $bundle->quantity,
            'qty_rejected'  => 'required|integer|min:0',
        ]);

        SewingProduction::create([
            'bundle_id'     => $bundle->id,
            'line_number'   => $request->line_number,
            'operator_name' => $request->operator_name,
            'operation'     => $request->operation,
            'qty_passed'    => $request->qty_passed,
            'qty_rejected'  => $request->qty_rejected,
        ]);

        $bundle->update(['status' => 'in_sewing']);

        return redirect()->route('sewing.scan')->with('success', "Sewing data recorded for Bundle {$bundle->bundle_no}");
    }
}
