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
            $table->renameColumn('variant_size_id', 'variant_size');
        });
        Schema::table('product_variant_sizes', function (Blueprint $table) {
            $table->string('variant_size', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variant_sizes', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_size')->change();
            $table->renameColumn('variant_size', 'variant_size_id');
        });
    }
};
