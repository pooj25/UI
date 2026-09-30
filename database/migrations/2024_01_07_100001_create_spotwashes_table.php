<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spotwashes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->constrained('bundles')->cascadeOnDelete();
            $table->integer('quantity_sent');
            $table->string('stain_type', 100);
            $table->enum('status', ['in_wash', 'cleaned', 'rejected'])->default('in_wash');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spotwashes');
    }
};
