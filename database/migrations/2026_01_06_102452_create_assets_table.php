<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag')->unique(); // كود الشركة
            $table->string('serial_number')->nullable()->unique();
            $table->foreignId('category_id')->constrained('asset_categories');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('brand_id')->constrained('brands');
            $table->foreignId('type_model_id')->constrained('type_models');
            $table->string('status');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
