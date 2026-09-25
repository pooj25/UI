<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabric_group_fabric', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fabric_group_id')
                  ->constrained('fabric_groups')
                  ->onDelete('cascade');
            $table->foreignId('fabric_id')
                  ->constrained('fabrics')
                  ->onDelete('cascade');
            $table->timestamps();
            $table->unique(['fabric_group_id', 'fabric_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabric_group_fabric');
    }
};
