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
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropUnique('unique_default_address');
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
        // Xóa foreign key vừa thêm
        $table->dropForeign(['user_id']);
        });

        Schema::table('addresses', function (Blueprint $table) {
        // Thêm lại unique index
        $table->unique(['user_id', 'is_default'], 'unique_default_address');
        });

        Schema::table('addresses', function (Blueprint $table) {
        // Thêm lại foreign key ban đầu
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
