<?php

namespace App\Http\Controllers;

use App\Models\GrnRoll;
use Illuminate\Http\Request;

class RollInventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = GrnRoll::with('grn.fabric');

        if ($request->search) {
            $query->where('roll_number', 'like', "%{$request->search}%")
                  ->orWhereHas('grn', function ($q) use ($request) {
                      $q->where('grn_number', 'like', "%{$request->search}%");
                  });
        }

        $rolls = $query->latest()->paginate(15);
        return view('roll_inventory.index', compact('rolls'));
    }

    public function show($id)
    {
        $roll = GrnRoll::with('grn.fabric', 'inspection')->findOrFail($id);
        return view('roll_inventory.show', compact('roll'));
    }
}
