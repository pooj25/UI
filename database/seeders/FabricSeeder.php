<?php

namespace Database\Seeders;

use App\Models\Fabric;
use Illuminate\Database\Seeder;

class FabricSeeder extends Seeder
{
    public function run(): void
    {
        $fabrics = [
            [
                'fabric_code' => 'FAB-001',
                'fabric_name' => 'Cotton Single Jersey',
                'fabric_type' => 'Knitted',
                'composition' => '100% Cotton',
                'color'       => 'Black',
                'gsm'         => 180,
                'width'       => 72,
                'unit'        => 'KG',
                'description' => 'Standard cotton single jersey fabric for T-shirts',
                'status'      => 'active',
            ],
            [
                'fabric_code' => 'FAB-002',
                'fabric_name' => 'Cotton Rib',
                'fabric_type' => 'Knitted',
                'composition' => '95% Cotton, 5% Lycra',
                'color'       => 'White',
                'gsm'         => 220,
                'width'       => 68,
                'unit'        => 'KG',
                'description' => 'Cotton rib fabric with elastane for polo collars and cuffs',
                'status'      => 'active',
            ],
            [
                'fabric_code' => 'FAB-003',
                'fabric_name' => 'Cotton Interlock',
                'fabric_type' => 'Knitted',
                'composition' => '100% Cotton',
                'color'       => 'Navy Blue',
                'gsm'         => 200,
                'width'       => 70,
                'unit'        => 'KG',
                'description' => 'Double knit cotton interlock for premium garments',
                'status'      => 'active',
            ],
            [
                'fabric_code' => 'FAB-004',
                'fabric_name' => 'Polyester',
                'fabric_type' => 'Woven',
                'composition' => '100% Polyester',
                'color'       => 'Grey',
                'gsm'         => 150,
                'width'       => 58,
                'unit'        => 'Meter',
                'description' => 'Plain polyester woven fabric for activewear',
                'status'      => 'active',
            ],
            [
                'fabric_code' => 'FAB-005',
                'fabric_name' => 'Polyester Spandex',
                'fabric_type' => 'Knitted',
                'composition' => '88% Polyester, 12% Spandex',
                'color'       => 'Black',
                'gsm'         => 230,
                'width'       => 60,
                'unit'        => 'KG',
                'description' => 'High stretch polyester spandex for sportswear',
                'status'      => 'active',
            ],
        ];

        foreach ($fabrics as $fabric) {
            Fabric::firstOrCreate(['fabric_code' => $fabric['fabric_code']], $fabric);
        }
    }
}
