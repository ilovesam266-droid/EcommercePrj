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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'payment_transaction_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->tinyInteger('payment_method')->comment("0:cash on delivery, 1:credit card, 2:e-wallet")->default(0);
            $table->tinyInteger('payment_status')->comment("0: pending, 1: paid, 2: failed")->default(0);
            $table->string('payment_transaction_code', 100)->nullable();
        });
    }
};
