<?php

namespace App\Http\Controllers;

use App\Models\FabricInspection;
use Illuminate\Http\Request;

class FabricInspectionController extends Controller
{
    public function index(Request $request)
    {
        $query = FabricInspection::with('roll.grn');

        if ($request->search) {
            $query->whereHas('roll', function ($q) use ($request) {
                $q->where('roll_number', 'like', "%{$request->search}%");
            });
        }

        $inspections = $query->latest()->paginate(15);
        return view('fabric_inspection.index', compact('inspections'));
    }

    public function show($id)
    {
        $inspection = FabricInspection::with('roll.grn')->findOrFail($id);
        return view('fabric_inspection.show', compact('inspection'));
    }
}
