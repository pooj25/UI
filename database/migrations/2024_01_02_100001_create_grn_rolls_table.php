<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grn_rolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grn_id')->constrained('grns')->cascadeOnDelete();
            $table->string('roll_number', 50)->unique();
            $table->decimal('roll_weight', 8, 2)->nullable()->comment('in KG');
            $table->decimal('roll_length', 8, 2)->nullable()->comment('in Meters');
            $table->decimal('actual_width', 6, 2)->nullable()->comment('measured width in inches');
            $table->string('qr_code', 200)->unique()->comment('encoded string used for QR');
            $table->enum('status', [
                'pending_inspection',
                'inspected',
                'in_stock',
                'reserved',
                'issued',
                'returned',
                'rejected',
            ])->default('pending_inspection');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grn_rolls');
    }
};
