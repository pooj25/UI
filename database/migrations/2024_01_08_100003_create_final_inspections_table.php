<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_inspections', function (Blueprint $table) {
            $table->id();
            $table->string('lot_number')->unique();
            $table->string('po_number');
            $table->string('buyer_name');
            $table->string('style_code');
            $table->integer('offer_qty')->default(0);
            $table->integer('sample_size')->default(0);
            $table->integer('major_defects')->default(0);
            $table->integer('minor_defects')->default(0);
            $table->string('result')->default('PASS'); // PASS, FAIL, HOLD, REINSPECT
            $table->string('inspector_name')->nullable();
            $table->date('inspection_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_inspections');
    }
};
