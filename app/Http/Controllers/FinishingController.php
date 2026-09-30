<?php

namespace App\Http\Controllers;

use App\Models\Finishing;
use Illuminate\Http\Request;

class FinishingController extends Controller
{
    public function index(Request $request)
    {
        $query = Finishing::query();

        if ($request->search) {
            $query->where('bundle_id', 'like', "%{$request->search}%")
                  ->orWhere('po_number', 'like', "%{$request->search}%")
                  ->orWhere('style', 'like', "%{$request->search}%");
        }

        $finishings = $query->latest()->paginate(15);
        return view('finishing_ui.index', compact('finishings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bundle_id' => 'nullable|string',
            'po_number' => 'nullable|string',
            'buyer' => 'nullable|string',
            'style' => 'nullable|string',
        ]);

        Finishing::create($validated);
        return redirect()->route('finishing-ui.index')->with('success', 'Finishing entry created.');
    }

    public function show(Finishing $finishing_ui)
    {
        return view('finishing_ui.show', ['finishing' => $finishing_ui]);
    }
}
