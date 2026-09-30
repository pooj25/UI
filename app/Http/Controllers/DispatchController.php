<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class DispatchController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::query();
        
        if ($request->search) {
            $query->where('shipment_number', 'like', "%{$request->search}%")
                  ->orWhere('buyer_name', 'like', "%{$request->search}%")
                  ->orWhere('po_number', 'like', "%{$request->search}%");
        }
        
        $shipments = $query->latest()->paginate(15);
        
        return view('dispatch_ui.index', compact('shipments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipment_number' => 'required|unique:shipments,shipment_number',
            'gate_pass_no' => 'nullable|string',
            'buyer_name' => 'required|string',
            'po_number' => 'required|string',
            'container_no' => 'nullable|string',
            'vehicle_no' => 'nullable|string',
            'destination' => 'nullable|string',
            'total_cartons' => 'required|integer',
            'total_pieces' => 'required|integer',
            'dispatch_date' => 'nullable|date',
        ]);

        Shipment::create($validated);

        return redirect()->route('dispatch-ui.index')->with('success', 'Shipment created successfully.');
    }

    public function show(Shipment $dispatch_ui)
    {
        return view('dispatch_ui.show', ['shipment' => $dispatch_ui]);
    }
}
