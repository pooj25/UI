<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cut_orders', function (Blueprint $table) {
            $table->id();
            $table->string('cut_order_no', 30)->unique();
            $table->foreignId('fabric_reservation_id')->nullable()->constrained('fabric_reservations')->nullOnDelete();
            $table->foreignId('lay_model_id')->constrained('lay_models')->restrictOnDelete();
            $table->integer('planned_qty')->default(0);
            $table->date('planned_date');
            $table->enum('status', ['planned', 'cutting', 'completed'])->default('planned');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('cut_order_rolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cut_order_id')->constrained('cut_orders')->cascadeOnDelete();
            $table->foreignId('grn_roll_id')->constrained('grn_rolls')->cascadeOnDelete();
            $table->decimal('used_length', 8, 2)->nullable()->comment('in Meters');
            $table->decimal('used_weight', 8, 2)->nullable()->comment('in KG');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cut_order_rolls');
        Schema::dropIfExists('cut_orders');
    }
};
