<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\SuperMarket;
use Illuminate\Http\Request;

class SuperMarketController extends Controller
{
    public function index()
    {
        $superMarkets = SuperMarket::with('bundle')->latest()->get();
        return view('supermarket.index', compact('superMarkets'));
    }

    public function scanIn()
    {
        return view('supermarket.scan-in');
    }

    public function storeIn(Request $request)
    {
        $request->validate([
            'bundle_no' => 'required|exists:bundles,bundle_no',
            'bin_location' => 'required|string|max:50',
        ]);

        $bundle = Bundle::where('bundle_no', $request->bundle_no)->firstOrFail();

        // Check if already in supermarket
        $existing = SuperMarket::where('bundle_id', $bundle->id)->where('status', 'in_storage')->first();
        if ($existing) {
            return back()->with('error', 'Bundle is already stored in Bin: ' . $existing->bin_location);
        }

        SuperMarket::create([
            'bundle_id' => $bundle->id,
            'bin_location' => $request->bin_location,
            'status' => 'in_storage'
        ]);

        return redirect()->route('supermarket.index')->with('success', 'Bundle successfully received into Super Market.');
    }

    public function scanOut()
    {
        return view('supermarket.scan-out');
    }

    public function storeOut(Request $request)
    {
        $request->validate([
            'bundle_no' => 'required|exists:bundles,bundle_no',
            'issued_to_line' => 'required|string|max:50',
        ]);

        $bundle = Bundle::where('bundle_no', $request->bundle_no)->firstOrFail();
        
        $superMarket = SuperMarket::where('bundle_id', $bundle->id)->where('status', 'in_storage')->first();
        if (!$superMarket) {
            return back()->with('error', 'Bundle is not currently in Super Market storage.');
        }

        $superMarket->update([
            'status' => 'issued',
            'issued_to_line' => $request->issued_to_line
        ]);

        return redirect()->route('supermarket.index')->with('success', 'Bundle successfully issued to ' . $request->issued_to_line);
    }
}
