<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boms', function (Blueprint $table) {
            $table->id();
            $table->string('bom_code')->unique();
            $table->string('style_code');
            $table->string('buyer_name')->nullable();
            $table->string('season')->default('SS26');
            $table->string('garment_type')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        Schema::create('bom_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_id')->constrained('boms')->onDelete('cascade');
            $table->string('item_name');
            $table->string('category')->default('Fabric'); // Fabric, Lining, Trims, Thread, Packaging
            $table->string('unit')->default('Meters');
            $table->decimal('consumption', 10, 4)->default(0);
            $table->decimal('wastage_pct', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bom_items');
        Schema::dropIfExists('boms');
    }
};
