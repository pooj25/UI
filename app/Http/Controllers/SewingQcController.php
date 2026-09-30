<?php

namespace App\Http\Controllers;

use App\Models\SewingProduction;
use Illuminate\Http\Request;

class SewingQcController extends Controller
{
    public function index(Request $request)
    {
        $query = SewingProduction::query();

        if ($request->search) {
            $query->where('bundle_id', 'like', "%{$request->search}%")
                  ->orWhere('operator_id', 'like', "%{$request->search}%");
        }

        $qc_logs = $query->latest()->paginate(15);
        return view('sewing_qc.index', compact('qc_logs'));
    }

    public function show($id)
    {
        $log = SewingProduction::findOrFail($id);
        return view('sewing_qc.show', compact('log'));
    }
}
