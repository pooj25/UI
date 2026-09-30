<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packings', function (Blueprint $table) {
            $table->id();
            $table->string('carton_number', 50)->unique();
            $table->foreignId('bundle_id')->constrained('bundles')->cascadeOnDelete();
            $table->string('size', 20)->nullable();
            $table->integer('quantity_packed');
            $table->string('packed_by', 100)->nullable();
            $table->enum('status', ['packed', 'shipped'])->default('packed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packings');
    }
};
