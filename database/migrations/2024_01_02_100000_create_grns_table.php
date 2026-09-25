<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grns', function (Blueprint $table) {
            $table->id();
            $table->string('grn_number', 20)->unique();
            $table->string('invoice_number', 100);
            $table->string('supplier_name', 200);
            $table->foreignId('fabric_id')->constrained('fabrics')->restrictOnDelete();
            $table->date('received_date');
            $table->string('rack_location', 100)->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['open', 'closed', 'cancelled'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grns');
    }
};
