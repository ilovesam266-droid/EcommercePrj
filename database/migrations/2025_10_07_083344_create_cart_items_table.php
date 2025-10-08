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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->integer('product_variant_size_id');
            $table->integer('cart_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->unique(['product_variant_size_id', 'cart_id']);
            $table->index('cart_id');
            $table->index('product_variant_size_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
