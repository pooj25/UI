<?php

namespace App\Http\Controllers;

use App\Models\TraceabilityLog;
use Illuminate\Http\Request;

class TraceabilityController extends Controller
{
    public function index(Request $request)
    {
        $query = TraceabilityLog::query();
        
        if ($request->search) {
            $query->where('trace_code', 'like', "%{$request->search}%")
                  ->orWhere('po_number', 'like', "%{$request->search}%")
                  ->orWhere('roll_id', 'like', "%{$request->search}%");
        }
        
        $logs = $query->latest()->paginate(15);
        
        return view('traceability.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trace_code' => 'required|string',
            'master_po' => 'nullable|string',
            'fabric_roll_id' => 'nullable|string',
            'cut_no' => 'nullable|string',
            'bundle_id' => 'nullable|string',
            'carton_id' => 'nullable|string',
            'current_stage' => 'required|string',
            'status' => 'required|string',
        ]);

        TraceabilityLog::create($validated);

        return redirect()->route('traceability.index')->with('success', 'Traceability log created.');
    }

    public function show(TraceabilityLog $traceability)
    {
        return view('traceability.show', compact('traceability'));
    }
}
