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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by');
            $table->string('title', 255);
            $table->text('body', 1000);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->index('created_by');
            $table->index('scheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaitions');
    }
};
