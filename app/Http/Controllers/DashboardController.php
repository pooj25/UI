<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with summary counts.
     */
    public function index()
    {
        $stats = [
            'total_fabrics'       => Fabric::count(),
            'total_fabric_groups' => FabricGroup::count(),
            'total_lay_models'    => LayModel::count(),
            'active_fabrics'      => Fabric::where('status', 'active')->count(),
            'active_groups'       => FabricGroup::where('status', 'active')->count(),
            'active_lay_models'   => LayModel::where('status', 'active')->count(),
        ];

        $recentFabrics = Fabric::latest()->take(5)->get();
        $recentLayModels = LayModel::with(['fabricGroup', 'fabric'])->latest()->take(5)->get();

        return view('dashboard.index', compact('stats', 'recentFabrics', 'recentLayModels'));
    }
}
