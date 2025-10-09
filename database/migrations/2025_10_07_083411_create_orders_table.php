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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('restrict');//if user is deleted, all his orders are deleted
            $table->integer('status')->comment("0: pending, 1: confirmed, 2: shipping, 3: buyer cancel, 4: admin cancel, 5: failed, 6: done")->default(0);
            $table->unsignedBigInteger('total_amount')->default(0);
            $table->unsignedBigInteger('shipping_fee')->default(0);
            $table->string('recipient_name', 100);
            $table->string('recipient_phone', 15);
            $table->string('province', 100);
            $table->string('district', 100);
            $table->string('ward', 100);
            $table->string('detailed_address', 255);
            $table->unsignedBigInteger('shipping_fee')->default(0);

            $table->tinyInteger('payment_method')->comment("0: cash on delivery, 1: credit card, 2: e-wallet")->default(0);
            $table->tinyInteger('payment_status')->comment("0: pending, 1: paid, 2: failed")->default(0);
            $table->string('payment_transaction_code', 100)->nullable();

            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('shipping_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('done_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('owner_id');
            $table->index('status');
            $table->index('payment_status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
