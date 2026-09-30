<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('traceability_logs', function (Blueprint $table) {
            $table->id();
            $table->string('trace_code')->unique();
            $table->string('po_number');
            $table->string('roll_id')->nullable();
            $table->string('cut_no')->nullable();
            $table->string('bundle_id')->nullable();
            $table->string('pack_id')->nullable();
            $table->string('carton_id')->nullable();
            $table->string('current_stage')->default('GRN Inward');
            $table->string('status')->default('Verified & Complete');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('traceability_logs');
    }
};
