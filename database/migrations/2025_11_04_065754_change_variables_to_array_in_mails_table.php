<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mails', function (Blueprint $table) {
            $table->json('variables')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('mails', function (Blueprint $table) {
            $table->text('variables')->nullable()->change(); // hoặc string nếu trước đó là string
        });
    }
};
