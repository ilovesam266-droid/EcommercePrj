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
        Schema::table('product_variant_sizes', function (Blueprint $table) {
            $table->dropForeign(['variant_size_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variant_sizes', function (Blueprint $table) {
            $table->foreign('variant_size_id')
                  ->references('id')
                  ->on('variant_sizes')
                  ->onDelete('restrict');
        });
    }
};
