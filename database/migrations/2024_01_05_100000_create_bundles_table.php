<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('bundle_no', 30)->unique();
            $table->foreignId('cut_order_id')->constrained('cut_orders')->cascadeOnDelete();
            $table->string('size', 10);
            $table->integer('quantity');
            $table->enum('status', ['generated', 'in_sewing', 'completed'])->default('generated');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundles');
    }
};
