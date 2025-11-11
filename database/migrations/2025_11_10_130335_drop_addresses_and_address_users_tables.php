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
        Schema::dropIfExists('address_users');
        Schema::dropIfExists('addresses');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_name', 100);
            $table->string('recipient_phone', 20);
            $table->string('province', 100);
            $table->string('district', 100);
            $table->string('ward', 100);
            $table->string('detailed_address', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('address_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id')->constrained('addresses')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['address_id', 'user_id']);
        });
    }
};
