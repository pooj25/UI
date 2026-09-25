<?php

namespace Database\Seeders;

use App\Models\Fabric;
use App\Models\FabricGroup;
use Illuminate\Database\Seeder;

class FabricGroupSeeder extends Seeder
{
    public function run(): void
    {
        $cottonGroup = FabricGroup::firstOrCreate(
            ['group_code' => 'FG-001'],
            [
                'group_name'  => 'Cotton Knitted Fabrics',
                'description' => 'All cotton knitted fabrics for jersey and rib production',
                'status'      => 'active',
            ]
        );
        $cottonFabrics = Fabric::whereIn('fabric_code', ['FAB-001', 'FAB-002', 'FAB-003'])->pluck('id');
        $cottonGroup->fabrics()->sync($cottonFabrics);

        $syntheticGroup = FabricGroup::firstOrCreate(
            ['group_code' => 'FG-002'],
            [
                'group_name'  => 'Synthetic Fabrics',
                'description' => 'Polyester and synthetic blend fabrics for activewear',
                'status'      => 'active',
            ]
        );
        $syntheticFabrics = Fabric::whereIn('fabric_code', ['FAB-004', 'FAB-005'])->pluck('id');
        $syntheticGroup->fabrics()->sync($syntheticFabrics);
    }
}
