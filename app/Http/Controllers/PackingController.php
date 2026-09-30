<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Packing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackingController extends Controller
{
    public function index()
    {
        $packings = Packing::with('bundle')->latest()->get();
        return view('packing.index', compact('packings'));
    }

    public function scan()
    {
        return view('packing.scan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bundle_no' => 'required|string|exists:bundles,bundle_no',
            'quantity_packed' => 'required|integer|min:1',
            'packed_by' => 'required|string|max:100',
        ]);

        $bundle = Bundle::where('bundle_no', $request->bundle_no)->firstOrFail();

        // Check if quantity doesn't exceed bundle quantity
        if ($request->quantity_packed > $bundle->quantity) {
            return back()->with('error', 'Packed quantity cannot exceed bundle quantity.');
        }

        $cartonNo = 'CRTN-' . strtoupper(Str::random(6));

        Packing::create([
            'carton_number' => $cartonNo,
            'bundle_id' => $bundle->id,
            'size' => $bundle->size,
            'quantity_packed' => $request->quantity_packed,
            'packed_by' => $request->packed_by,
        ]);

        $bundle->update(['status' => 'completed']);

        return redirect()->route('packing.index')->with('success', "Garments packed into Carton: $cartonNo");
    }

    public function printQr(Packing $packing)
    {
        return view('packing.print-qr', compact('packing'));
    }
}
