<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabric_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_no', 30)->unique();
            $table->foreignId('lay_model_id')->nullable()->constrained('lay_models')->nullOnDelete();
            $table->date('request_date');
            $table->string('requested_by', 100)->nullable();
            $table->enum('status', ['pending', 'approved', 'issued', 'cancelled'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('fabric_reservation_rolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fabric_reservation_id')->constrained('fabric_reservations')->cascadeOnDelete();
            $table->foreignId('grn_roll_id')->constrained('grn_rolls')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabric_reservation_rolls');
        Schema::dropIfExists('fabric_reservations');
    }
};
