<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Buyers
        DB::table('buyers')->insertOrIgnore([
            ['id' => 1, 'name' => 'H&M Global', 'code' => 'BUY-HM', 'country' => 'Sweden', 'status' => 'Active', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Zara Inc', 'code' => 'BUY-ZA', 'country' => 'Spain', 'status' => 'Active', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 2. Purchase Orders
        DB::table('purchase_orders')->insertOrIgnore([
            ['id' => 1, 'buyer_id' => 1, 'po_number' => 'PO-HM-1001', 'style_name' => 'Basic V-Neck Tee', 'style_code' => 'ST-VNK-001', 'season' => 'SS26', 'order_qty' => 5000, 'delivery_date' => $now->addDays(30), 'status' => 'Open', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'buyer_id' => 2, 'po_number' => 'PO-ZA-2005', 'style_name' => 'Oversized Hoodie', 'style_code' => 'ST-HD-005', 'season' => 'AW26', 'order_qty' => 3000, 'delivery_date' => $now->addDays(45), 'status' => 'Open', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 3. BOMs
        DB::table('boms')->insertOrIgnore([
            ['id' => 1, 'bom_code' => 'BOM-VNK-001', 'style_code' => 'ST-VNK-001', 'buyer_name' => 'H&M Global', 'garment_type' => 'T-Shirt', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'bom_code' => 'BOM-HD-005', 'style_code' => 'ST-HD-005', 'buyer_name' => 'Zara Inc', 'garment_type' => 'Hoodie', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // BOM Items
        DB::table('bom_items')->insertOrIgnore([
            ['bom_id' => 1, 'item_name' => '100% Cotton Single Jersey 160 GSM', 'category' => 'Fabric', 'consumption' => 1.2, 'created_at' => $now, 'updated_at' => $now],
            ['bom_id' => 1, 'item_name' => 'Thread 40/2 spun poly', 'category' => 'Thread', 'consumption' => 150, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 4. Suppliers
        DB::table('suppliers')->insertOrIgnore([
            ['id' => 1, 'name' => 'Sunrise Textiles', 'code' => 'SUP-001', 'category' => 'Fabric Mill', 'city' => 'Tirupur', 'status' => 'Active', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Delta Trims', 'code' => 'SUP-002', 'category' => 'Trim Supplier', 'city' => 'Mumbai', 'status' => 'Active', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Use Fabric ID 1 for testing (Assuming FabricSeeder was run, it usually creates ID 1)
        $fabricId = DB::table('fabrics')->value('id');
        if (!$fabricId) {
            // Create dummy fabric if missing
            DB::table('fabrics')->insertOrIgnore([
                ['id' => 1, 'fabric_code' => 'FAB-TEST', 'fabric_name' => 'Test Cotton', 'created_at' => $now, 'updated_at' => $now]
            ]);
            $fabricId = 1;
        }

        // 5. GRNs
        DB::table('grns')->insertOrIgnore([
            ['id' => 1, 'grn_number' => 'GRN-2026-001', 'invoice_number' => 'INV-9988', 'supplier_name' => 'Sunrise Textiles', 'fabric_id' => $fabricId, 'received_date' => $now->subDays(5), 'status' => 'closed', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // GRN Rolls
        DB::table('grn_rolls')->insertOrIgnore([
            ['id' => 1, 'grn_id' => 1, 'roll_number' => 'ROLL-001', 'roll_weight' => 25.5, 'roll_length' => 150, 'qr_code' => 'QR-R001', 'status' => 'inspected', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'grn_id' => 1, 'roll_number' => 'ROLL-002', 'roll_weight' => 24.8, 'roll_length' => 148, 'qr_code' => 'QR-R002', 'status' => 'in_stock', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 6. Fabric Inspections
        DB::table('fabric_inspections')->insertOrIgnore([
            ['grn_roll_id' => 1, 'inspected_by' => 'Rajesh QC', 'inspection_date' => $now->subDays(4), 'defects_found' => 2, 'dhu_percent' => 1.5, 'overall_result' => 'Pass', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 7. Finishings
        DB::table('finishings')->insertOrIgnore([
            ['bundle_id' => 'BUN-VNK-101', 'po_number' => 'PO-HM-1001', 'buyer' => 'H&M Global', 'style' => 'Basic V-Neck Tee', 'washing_status' => 'Completed', 'ironing_status' => 'In Progress', 'folding_status' => 'Pending', 'qc_status' => 'Pending', 'created_at' => $now, 'updated_at' => $now],
            ['bundle_id' => 'BUN-VNK-102', 'po_number' => 'PO-HM-1001', 'buyer' => 'H&M Global', 'style' => 'Basic V-Neck Tee', 'washing_status' => 'Completed', 'ironing_status' => 'Completed', 'folding_status' => 'Completed', 'qc_status' => 'Passed', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
