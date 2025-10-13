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
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('variant_size_id')->constrained('variant_sizes')->onDelete('restrict');
            $table->string('sku', 100);
            $table->unsignedBigInteger('price');
            $table->integer('total_sold')->default(0);
            $table->integer('stock')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['product_id', 'variant_size_id']);
            $table->index('sku'); // Nếu tìm kiếm theo SKU
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
