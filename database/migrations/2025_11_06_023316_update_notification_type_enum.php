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
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->enum('type', [
                'user_registered',
                'order_confirmed',
                'order_shipping',
                'order_done',
                'order_canceled',
                'order_failed',
                'personal_offer',
                'newsletter',
                'email_verified',
                'system_alert', // ✅ thêm vào đây
            ])->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
