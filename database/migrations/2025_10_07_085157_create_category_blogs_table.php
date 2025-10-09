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
        Schema::create('category_blogs', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('blog_id');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['category_id', 'blog_id']);
            $table->index(['category_id', 'blog_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_blogs');
    }
};
