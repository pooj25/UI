<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLayModelRequest;
use App\Http\Requests\UpdateLayModelRequest;
use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;
use Illuminate\Http\Request;

class LayModelController extends Controller
{
    public function index(Request $request)
    {
        $query = LayModel::with(['fabricGroup', 'fabric']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lay_model_code', 'like', "%{$search}%")
                  ->orWhere('lay_model_name', 'like', "%{$search}%")
                  ->orWhere('garment_size', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('fabric_group_id')) {
            $query->where('fabric_group_id', $request->fabric_group_id);
        }

        $layModels = $query->latest()->paginate(15)->withQueryString();
        $fabricGroups = FabricGroup::where('status', 'active')->orderBy('group_name')->get();

        return view('lay-models.index', compact('layModels', 'fabricGroups'));
    }

    public function create()
    {
        $fabricGroups = FabricGroup::where('status', 'active')->orderBy('group_name')->get();
        $fabrics = collect();
        return view('lay-models.create', compact('fabricGroups', 'fabrics'));
    }

    public function store(StoreLayModelRequest $request)
    {
        $layModel = LayModel::create($request->validated());
        return redirect()->route('lay-models.show', $layModel)
            ->with('success', "Lay Model '{$layModel->lay_model_name}' created successfully.");
    }

    public function show(LayModel $layModel)
    {
        $layModel->load('fabricGroup', 'fabric');
        return view('lay-models.show', compact('layModel'));
    }

    public function edit(LayModel $layModel)
    {
        $fabricGroups = FabricGroup::where('status', 'active')->orderBy('group_name')->get();
        $fabrics = Fabric::whereHas('groups', function ($q) use ($layModel) {
            $q->where('fabric_groups.id', $layModel->fabric_group_id);
        })->where('status', 'active')->orderBy('fabric_code')->get();

        return view('lay-models.edit', compact('layModel', 'fabricGroups', 'fabrics'));
    }

    public function update(UpdateLayModelRequest $request, LayModel $layModel)
    {
        $layModel->update($request->validated());
        return redirect()->route('lay-models.show', $layModel)
            ->with('success', "Lay Model '{$layModel->lay_model_name}' updated successfully.");
    }

    public function destroy(LayModel $layModel)
    {
        $name = $layModel->lay_model_name;
        $layModel->delete();
        return redirect()->route('lay-models.index')
            ->with('success', "Lay Model '{$name}' deleted successfully.");
    }

    public function getFabricsByGroup(Request $request)
    {
        $request->validate(['fabric_group_id' => 'required|exists:fabric_groups,id']);
        $fabrics = Fabric::whereHas('groups', function ($q) use ($request) {
            $q->where('fabric_groups.id', $request->fabric_group_id);
        })->where('status', 'active')
          ->orderBy('fabric_code')
          ->get(['id', 'fabric_code', 'fabric_name']);

        return response()->json($fabrics);
    }
}
