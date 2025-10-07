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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('restrict');//restrict deletion if any order is using this payment
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');//restrict deletion if any user is using this payment
            $table->unsignedBigInteger('amount');
            $table->tinyInteger('payment_method')->comment("0: cash on delivery, 1: credit card, 2: e-wallet")->default(0);
            $table->string('transaction_code', 100)->nullable();
            $table->tinyInteger('status')->comment("0: pending, 1: completed, 2: failed")->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
