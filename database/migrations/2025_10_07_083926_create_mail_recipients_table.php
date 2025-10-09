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
        Schema::create('mail_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mail_id')->constrained('mails')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('email', 100)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: unread, 1: read');
            $table->string('error_message', 255)->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'mail_id']);
            $table->index('user_id');
            $table->index('mail_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_recipients');
    }
};
