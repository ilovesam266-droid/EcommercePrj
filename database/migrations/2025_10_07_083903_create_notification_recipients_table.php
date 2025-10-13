<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\NotificationRecipientStatus;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notification_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('notification_id')->constrained('notifications')->onDelete('restrict');
            $table->string('email', 100)->nullable();
            $table->enum('status', array_column(NotificationRecipientStatus::cases(), 'value'))
            ->default(NotificationRecipientStatus::UNREAD->value)
            ->comment('statuses: unread, read, failed');
            $table->string('error_message', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'notification_id']);
            $table->index('user_id');
            $table->index('notification_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaition_recipients');
    }
};
