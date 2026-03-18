<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenance_body_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_head_invoice_id')->constrained('maintenance_head_invoices')->onDelete('cascade');
            $table->foreignId('asset_id')->constrained('assets');
            $table->string('reason')->nullable();
            $table->string('received_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_body_invoices');
    }
};
