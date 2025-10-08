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
        Schema::create('product_variant_sizes', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('variant_size_id');
            $table->string('sku', 100);
            $table->unsignedBigInt('price');
            $table->integer('total_sold')->default(0);
            $table->integer('stock')->default(0);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unique(['product_id', 'variant_size_id']);
            $table->index('product_id');
            $table->index('variant_size_id');
            $table->index('sku');
            $table->index('price');
            $table->index('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_sizes');
    }
};
