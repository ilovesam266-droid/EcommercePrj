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

        Schema::table('mail_recipients', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['mail_id']);

            $table->dropUnique('mail_recipients_user_id_mail_id_unique');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mail_id')->references('id')->on('mails')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_recipients', function (Blueprint $table) {
            // Drop foreign keys trước
            $table->dropForeign(['user_id']);
            $table->dropForeign(['mail_id']);

            // Thêm lại unique index
            $table->unique(['user_id', 'mail_id'], 'mail_recipients_user_id_mail_id_unique');

            // Thêm lại foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mail_id')->references('id')->on('mails')->onDelete('cascade');
        });
    }
};
