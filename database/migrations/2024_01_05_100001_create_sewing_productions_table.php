<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sewing_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->constrained('bundles')->cascadeOnDelete();
            $table->string('line_number', 50)->nullable();
            $table->string('operator_name', 100)->nullable();
            $table->string('operation', 100)->nullable();
            $table->integer('qty_passed')->default(0);
            $table->integer('qty_rejected')->default(0);
            $table->timestamp('scanned_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sewing_productions');
    }
};
