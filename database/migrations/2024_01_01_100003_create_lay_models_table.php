<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lay_models', function (Blueprint $table) {
            $table->id();
            $table->string('lay_model_code')->unique();
            $table->string('lay_model_name');
            $table->foreignId('fabric_group_id')
                  ->constrained('fabric_groups')
                  ->onDelete('restrict');
            $table->foreignId('fabric_id')
                  ->constrained('fabrics')
                  ->onDelete('restrict');
            $table->decimal('lay_length', 10, 2);
            $table->decimal('lay_width', 10, 2);
            $table->integer('number_of_plies');
            $table->string('garment_size')->nullable();
            $table->decimal('marker_length', 10, 2)->nullable();
            $table->decimal('marker_width', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lay_models');
    }
};
