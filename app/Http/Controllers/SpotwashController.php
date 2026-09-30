<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Spotwash;
use Illuminate\Http\Request;

class SpotwashController extends Controller
{
    public function index()
    {
        $spotwashes = Spotwash::with('bundle')->latest()->get();
        return view('spotwash.index', compact('spotwashes'));
    }

    public function send()
    {
        return view('spotwash.send');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bundle_no' => 'required|exists:bundles,bundle_no',
            'quantity_sent' => 'required|integer|min:1',
            'stain_type' => 'required|string|max:100',
        ]);

        $bundle = Bundle::where('bundle_no', $request->bundle_no)->firstOrFail();

        Spotwash::create([
            'bundle_id' => $bundle->id,
            'quantity_sent' => $request->quantity_sent,
            'stain_type' => $request->stain_type,
            'status' => 'in_wash'
        ]);

        return redirect()->route('spotwash.index')->with('success', 'Garments successfully sent to Spotwash.');
    }

    public function markCleaned(Spotwash $spotwash)
    {
        $spotwash->update(['status' => 'cleaned']);
        return back()->with('success', 'Garments marked as cleaned and returned to line.');
    }
}
