<?php

namespace Database\Seeders;

use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;
use Illuminate\Database\Seeder;

class LayModelSeeder extends Seeder
{
    public function run(): void
    {
        $cottonGroup  = FabricGroup::where('group_code', 'FG-001')->first();
        $singleJersey = Fabric::where('fabric_code', 'FAB-001')->first();
        $cottonRib    = Fabric::where('fabric_code', 'FAB-002')->first();

        if ($cottonGroup && $singleJersey) {
            LayModel::firstOrCreate(
                ['lay_model_code' => 'LM-001'],
                [
                    'lay_model_name'  => "Men's T-Shirt Lay",
                    'fabric_group_id' => $cottonGroup->id,
                    'fabric_id'       => $singleJersey->id,
                    'lay_length'      => 12.50,
                    'lay_width'       => 72,
                    'number_of_plies' => 50,
                    'garment_size'    => 'L',
                    'marker_length'   => 11.80,
                    'marker_width'    => 68,
                    'description'     => "Standard lay model for men's T-shirt production",
                    'status'          => 'active',
                ]
            );
        }

        if ($cottonGroup && $cottonRib) {
            LayModel::firstOrCreate(
                ['lay_model_code' => 'LM-002'],
                [
                    'lay_model_name'  => "Men's Polo Lay",
                    'fabric_group_id' => $cottonGroup->id,
                    'fabric_id'       => $cottonRib->id,
                    'lay_length'      => 14.00,
                    'lay_width'       => 68,
                    'number_of_plies' => 40,
                    'garment_size'    => 'XL',
                    'marker_length'   => 13.20,
                    'marker_width'    => 65,
                    'description'     => "Lay model for men's polo shirt with rib fabric",
                    'status'          => 'active',
                ]
            );
        }
    }
}
