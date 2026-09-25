<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabric_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grn_roll_id')->constrained('grn_rolls')->cascadeOnDelete();
            $table->string('inspected_by', 100);
            $table->date('inspection_date');
            $table->enum('shade_result', ['OK', 'NG'])->default('OK');
            $table->text('shade_notes')->nullable();
            $table->decimal('shrinkage_warp', 5, 2)->nullable()->comment('warp shrinkage %');
            $table->decimal('shrinkage_weft', 5, 2)->nullable()->comment('weft shrinkage %');
            $table->decimal('width_result', 6, 2)->nullable()->comment('measured width in inches');
            $table->integer('defects_found')->default(0);
            $table->integer('pieces_inspected')->default(1);
            $table->decimal('dhu_percent', 6, 2)->default(0)->comment('auto-calculated');
            $table->enum('overall_result', ['Pass', 'Fail', 'Conditional'])->default('Pass');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabric_inspections');
    }
};
