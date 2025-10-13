<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PaymentStatus;
use App\Enums\PaymentMethod;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('amount');
            $table->enum('payment_method', array_column(PaymentMethod::cases(), 'value'))
                ->default('cash on delivery')
                ->comment('cash on delivery', 'credit card', 'paypal', 'bank transfer');
            $table->string('transaction_code', 100)->nullable()->unique();
            $table->enum('status', array_column(PaymentStatus::cases(), 'value'))
            ->default(PaymentStatus::PENDING->value)
            ->comment('statuses: pending, completed, failed, refunded');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id','order_id']);
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
