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
        Schema::table('address_users', function (Blueprint $table) {
            $table->string('recipient_name', 100);
            $table->string('recipient_phone', 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('address_users', function (Blueprint $table) {
            $table->dropColumn(['recipient_name', 'recipient_phone']);
        });
    }
};
