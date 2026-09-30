<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_number')->unique();
            $table->string('gate_pass_no')->nullable();
            $table->string('buyer_name');
            $table->string('po_number');
            $table->string('container_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('destination')->nullable();
            $table->integer('total_cartons')->default(0);
            $table->integer('total_pieces')->default(0);
            $table->string('status')->default('Pending'); // Pending, Staged, Loaded, Dispatched
            $table->date('dispatch_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
