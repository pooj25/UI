<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFabricRequest;
use App\Http\Requests\UpdateFabricRequest;
use App\Models\Fabric;
use Illuminate\Http\Request;

class FabricController extends Controller
{
    public function index(Request $request)
    {
        $query = Fabric::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('fabric_code', 'like', "%{$search}%")
                  ->orWhere('fabric_name', 'like', "%{$search}%")
                  ->orWhere('fabric_type', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $fabrics = $query->latest()->paginate(15)->withQueryString();
        return view('fabrics.index', compact('fabrics'));
    }

    public function create()
    {
        return view('fabrics.create');
    }

    public function store(StoreFabricRequest $request)
    {
        $fabric = Fabric::create($request->validated());
        return redirect()->route('fabrics.show', $fabric)
            ->with('success', "Fabric '{$fabric->fabric_name}' created successfully.");
    }

    public function show(Fabric $fabric)
    {
        $fabric->load('groups', 'layModels');
        return view('fabrics.show', compact('fabric'));
    }

    public function edit(Fabric $fabric)
    {
        return view('fabrics.edit', compact('fabric'));
    }

    public function update(UpdateFabricRequest $request, Fabric $fabric)
    {
        $fabric->update($request->validated());
        return redirect()->route('fabrics.show', $fabric)
            ->with('success', "Fabric '{$fabric->fabric_name}' updated successfully.");
    }

    public function destroy(Fabric $fabric)
    {
        if ($fabric->isInUse()) {
            return back()->with('error',
                "Cannot delete '{$fabric->fabric_name}'. This fabric is already used in a lay model.");
        }
        $name = $fabric->fabric_name;
        $fabric->delete();
        return redirect()->route('fabrics.index')
            ->with('success', "Fabric '{$name}' deleted successfully.");
    }
}
