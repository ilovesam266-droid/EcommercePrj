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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('product_variant_size_id');
            $table->unsignedBigInt('unit_price');
            $table->integer('quantity')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->index('order_id');
            $table->index('product_variant_size_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
