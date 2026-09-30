<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('finishings', function (Blueprint $table) {
            $table->id();
            $table->string('bundle_id')->nullable();
            $table->string('po_number')->nullable();
            $table->string('buyer')->nullable();
            $table->string('style')->nullable();
            $table->string('washing_status')->default('Pending');
            $table->string('ironing_status')->default('Pending');
            $table->string('folding_status')->default('Pending');
            $table->string('qc_status')->default('Pending');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finishings');
    }
};
