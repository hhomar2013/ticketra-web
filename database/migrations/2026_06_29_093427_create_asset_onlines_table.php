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
        Schema::create('asset_onlines', function (Blueprint $table) {
            $table->id();
            $table->string('computer_name');
            $table->string('manufacturer')->nullable(); // مثلاً Dell, Lenovo, Apple
            $table->string('model')->nullable();        // مثلاً ThinkPad E16, MacBook Air
            $table->string('serial_number')->unique();   // السيريال نمبر (مهم يكون Unique)
            $table->string('os_name')->nullable();       // Windows 11 Pro, macOS
            $table->string('os_version')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('windows_activation')->nullable(); // Licensed, Unlicensed, etc.
            $table->json('missing_drivers')->nullable();
            $table->json('installed_apps')->nullable();  // هنخزن البرامج هنا كـ JSON
            $table->json('hardware_specs')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // لو حابب تربط الجهاز بموظف معين
            $table->timestamp('last_sync_at')->nullable(); // وقت آخر تحديث للداتا
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_onlines');
    }
};
