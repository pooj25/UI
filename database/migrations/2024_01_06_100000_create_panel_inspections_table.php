<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panel_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cut_order_id')->constrained('cut_orders')->cascadeOnDelete();
            $table->string('inspector_name', 100);
            $table->integer('total_panels_checked');
            $table->integer('panels_passed');
            $table->integer('panels_rejected')->default(0);
            $table->text('defect_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panel_inspections');
    }
};
