<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFabricGroupRequest;
use App\Http\Requests\UpdateFabricGroupRequest;
use App\Models\Fabric;
use App\Models\FabricGroup;
use Illuminate\Http\Request;

class FabricGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = FabricGroup::withCount('fabrics');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('group_code', 'like', "%{$search}%")
                  ->orWhere('group_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $groups = $query->latest()->paginate(15)->withQueryString();
        return view('fabric-groups.index', compact('groups'));
    }

    public function create()
    {
        $fabrics = Fabric::where('status', 'active')->orderBy('fabric_code')->get();
        return view('fabric-groups.create', compact('fabrics'));
    }

    public function store(StoreFabricGroupRequest $request)
    {
        $data = $request->validated();
        $group = FabricGroup::create([
            'group_code'  => $data['group_code'],
            'group_name'  => $data['group_name'],
            'description' => $data['description'] ?? null,
            'status'      => $data['status'],
        ]);
        $group->fabrics()->sync($data['fabrics']);

        return redirect()->route('fabric-groups.show', $group)
            ->with('success', "Fabric Group '{$group->group_name}' created successfully.");
    }

    public function show(FabricGroup $fabricGroup)
    {
        $fabricGroup->load('fabrics', 'layModels');
        $availableFabrics = Fabric::where('status', 'active')
            ->whereNotIn('id', $fabricGroup->fabrics->pluck('id'))
            ->orderBy('fabric_code')
            ->get();
        return view('fabric-groups.show', compact('fabricGroup', 'availableFabrics'));
    }

    public function edit(FabricGroup $fabricGroup)
    {
        $fabrics = Fabric::where('status', 'active')->orderBy('fabric_code')->get();
        $selectedFabrics = $fabricGroup->fabrics->pluck('id')->toArray();
        return view('fabric-groups.edit', compact('fabricGroup', 'fabrics', 'selectedFabrics'));
    }

    public function update(UpdateFabricGroupRequest $request, FabricGroup $fabricGroup)
    {
        $data = $request->validated();
        $fabricGroup->update([
            'group_code'  => $data['group_code'],
            'group_name'  => $data['group_name'],
            'description' => $data['description'] ?? null,
            'status'      => $data['status'],
        ]);
        $fabricGroup->fabrics()->sync($data['fabrics']);

        return redirect()->route('fabric-groups.show', $fabricGroup)
            ->with('success', "Fabric Group '{$fabricGroup->group_name}' updated successfully.");
    }

    public function destroy(FabricGroup $fabricGroup)
    {
        if ($fabricGroup->layModels()->exists()) {
            return back()->with('error',
                "Cannot delete '{$fabricGroup->group_name}'. This group is used in lay models.");
        }
        $name = $fabricGroup->group_name;
        $fabricGroup->fabrics()->detach();
        $fabricGroup->delete();
        return redirect()->route('fabric-groups.index')
            ->with('success', "Fabric Group '{$name}' deleted successfully.");
    }

    public function removeFabric(FabricGroup $fabricGroup, Fabric $fabric)
    {
        $fabricGroup->fabrics()->detach($fabric->id);
        return back()->with('success',
            "Fabric '{$fabric->fabric_name}' removed from group '{$fabricGroup->group_name}'.");
    }

    public function addFabric(Request $request, FabricGroup $fabricGroup)
    {
        $request->validate(['fabric_id' => 'required|exists:fabrics,id']);
        $fabricGroup->fabrics()->syncWithoutDetaching([$request->fabric_id]);
        return back()->with('success', 'Fabric added to group successfully.');
    }
}
