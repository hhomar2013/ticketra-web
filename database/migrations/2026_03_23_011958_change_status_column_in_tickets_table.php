<?php

use App\Core\Enum\TicketStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', array_column(TicketStatus::cases(), 'value'))
                  ->default(TicketStatus::New->value)
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('status')->default('new')->change();
        });
    }
};
