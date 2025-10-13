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
        Schema::create('imageables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('image_id')->constrained('images')->onDelete('restrict');
            $table->boolean('is_primary')->default(false);// 0: not primary, 1: primary
            $table->integer('order_of_images')->nullable();
            $table->morphs('imageable');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['imageable_type', 'imageable_id', 'is_primary']);
            $table->index(['imageable_type', 'imageable_id', 'order_of_images']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagables');
    }
};
