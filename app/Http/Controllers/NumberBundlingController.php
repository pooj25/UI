<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\CutOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NumberBundlingController extends Controller
{
    public function index()
    {
        // Show all completed cut orders that can be bundled, plus recently created bundles
        $cutOrders = CutOrder::with('bundles')->where('status', 'completed')->latest()->get();
        return view('number-bundling.index', compact('cutOrders'));
    }

    public function create(CutOrder $cutOrder)
    {
        return view('number-bundling.create', compact('cutOrder'));
    }

    public function store(Request $request, CutOrder $cutOrder)
    {
        $request->validate([
            'bundles' => 'required|array|min:1',
            'bundles.*.size' => 'required|string',
            'bundles.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($request->bundles as $bundleData) {
            // Generate a unique bundle number (e.g., BNDL-CO12-S-491)
            $bundleNo = 'BNDL-' . $cutOrder->id . '-' . strtoupper($bundleData['size']) . '-' . strtoupper(Str::random(4));
            
            Bundle::create([
                'bundle_no'    => $bundleNo,
                'cut_order_id' => $cutOrder->id,
                'size'         => $bundleData['size'],
                'quantity'     => $bundleData['quantity'],
                'status'       => 'generated'
            ]);
        }

        return redirect()->route('number-bundling.index')->with('success', 'Bundles generated successfully.');
    }

    public function printQr(CutOrder $cutOrder)
    {
        $bundles = $cutOrder->bundles;
        return view('number-bundling.print-qr', compact('cutOrder', 'bundles'));
    }
}
