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
        Schema::table('mails', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('name');
            $table->dropColumn('scheduled_at');
        });
        Schema::table('mails', function (Blueprint $table) {
            $table->enum('type', ['order_paid', 'order_shipped', 'order_delivered', 'order_canceled', 'personal_offer', 'newsletter', 'user_registered', 'email_verification'])->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mails', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('mails', function (Blueprint $table) {
            $table->enum('type', [
                'transactional',
                'marketing',
                'newsletter',
                'onboarding',
                'retention',
                'feedback',
                'notification',
                'event'
            ])->default('transactional')->after('id');
            $table->string('name')->unique()->after('id');
            $table->timestamp('scheduled_at')->nullable();
        });
    }
};
