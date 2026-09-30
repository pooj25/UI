<?php

namespace App\Http\Controllers;

use App\Models\FinalInspection;
use Illuminate\Http\Request;

class FinalQcController extends Controller
{
    public function index(Request $request)
    {
        $query = FinalInspection::query();
        
        if ($request->search) {
            $query->where('lot_number', 'like', "%{$request->search}%")
                  ->orWhere('po_number', 'like', "%{$request->search}%")
                  ->orWhere('style_code', 'like', "%{$request->search}%");
        }
        
        $inspections = $query->latest()->paginate(15);
        
        return view('final_qc.index', compact('inspections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lot_number' => 'required|unique:final_inspections,lot_number',
            'po_number' => 'required|string',
            'buyer_name' => 'required|string',
            'style_code' => 'required|string',
            'offer_qty' => 'required|integer',
            'sample_size' => 'required|integer',
            'major_defects' => 'required|integer',
            'minor_defects' => 'required|integer',
            'result' => 'required|string',
            'inspector_name' => 'nullable|string',
            'inspection_date' => 'nullable|date',
        ]);

        FinalInspection::create($validated);

        return redirect()->route('final-qc.index')->with('success', 'Inspection report created successfully.');
    }

    public function show(FinalInspection $final_qc)
    {
        return view('final_qc.show', compact('final_qc'));
    }
}
