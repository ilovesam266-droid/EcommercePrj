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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            // Mỗi user có thể có nhiều địa chỉ
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Thông tin chi tiết địa chỉ
            $table->string('recipient_name', 100);
            $table->string('recipient_phone', 20);
            $table->string('province', 100);
            $table->string('district', 100);
            $table->string('ward', 100);
            $table->string('detailed_address', 255);

            // Địa chỉ mặc định
            $table->boolean('is_default')->default(false);

            $table->timestamps();
            $table->softDeletes();

            // Đảm bảo 1 user chỉ có 1 địa chỉ mặc định
            $table->unique(['user_id', 'is_default'], 'unique_default_address')
                  ->where('is_default', true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
