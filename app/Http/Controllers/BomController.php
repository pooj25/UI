<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\BomItem;
use Illuminate\Http\Request;

class BomController extends Controller
{
    public function index(Request $request)
    {
        $query = Bom::query();
        
        if ($request->search) {
            $query->where('bom_code', 'like', "%{$request->search}%")
                  ->orWhere('style_code', 'like', "%{$request->search}%");
        }
        
        $boms = $query->latest()->paginate(15);
        
        return view('bom.index', compact('boms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bom_code' => 'required|unique:boms,bom_code',
            'style_code' => 'required|string',
            'buyer_name' => 'nullable|string',
            'season' => 'nullable|string',
            'garment_type' => 'nullable|string',
        ]);

        Bom::create($validated);

        return redirect()->route('bom.index')->with('success', 'BOM created successfully.');
    }

    public function show(Bom $bom)
    {
        $bom->load('items');
        return view('bom.show', compact('bom'));
    }

    public function update(Request $request, Bom $bom)
    {
        $validated = $request->validate([
            'bom_code' => 'required|unique:boms,bom_code,' . $bom->id,
            'style_code' => 'required|string',
            'buyer_name' => 'nullable|string',
            'season' => 'nullable|string',
            'garment_type' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $bom->update($validated);

        return redirect()->route('bom.index')->with('success', 'BOM updated successfully.');
    }

    public function destroy(Bom $bom)
    {
        $bom->delete();
        return redirect()->route('bom.index')->with('success', 'BOM deleted successfully.');
    }
}
