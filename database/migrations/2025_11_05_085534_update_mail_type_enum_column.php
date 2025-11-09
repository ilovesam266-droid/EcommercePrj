<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('mails', function (Blueprint $table) {
            // Nếu đang dùng MySQL, cần drop cột trước khi tạo lại
            $table->dropColumn('type');
        });

        Schema::table('mails', function (Blueprint $table) {
            $table->enum('type', [
                'order_confirmed',
                'order_canceled',
                'order_shipping',
                'order_failed',
                'order_done',
                'personal_offer',
                'newsletter',
                'user_registered',
                'email_verification'
            ])->after('id');
        });
    }

    public function down()
    {
        Schema::table('mails', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('mails', function (Blueprint $table) {
            $table->enum('type', [
                'order_paid',
                'order_shipped',
                'order_delivered',
                'order_canceled',
                'personal_offer',
                'newsletter',
                'user_registered',
                'email_verification'
            ])->after('id');
        });
    }
};
