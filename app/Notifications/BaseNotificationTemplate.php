<?php

namespace App\Notifications;

use App\Models\Notification as Noti;
use App\Repository\Constracts\NotificationRecipientRepositoryInterface;
use App\Repository\Constracts\NotificationRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Blade;

abstract class BaseNotificationTemplate extends Notification
{
    use Queueable, SerializesModels;

    protected NotificationRepositoryInterface $notificationRepository;
    protected NotificationRecipientRepositoryInterface $notificationRecipientRepository;
    public Noti $notificationTemplate;
    public array $variables;

    // public function boot( NotificationRecipientRepositoryInterface $notification_recipient_repository,NotificationRepositoryInterface $notification_repository){
    //     $this->notificationRepository = $notification_repository;
    //     $this->notificationRecipientRepository = $notification_recipient_repository;
    // }
    // /**
    //  * Create a new notification instance.
    //  */
    // public function __construct(string $notification_template, array $variables)
    // {
    //     $this->notificationTemplate = $this->notificationRepository->findByType($notification_template);
    //     $this->variables = $variables;
    // }

    public function __construct(string $notification_template, array $variables)
    {
        // ✅ Resolve repository từ container thay vì yêu cầu trong constructor
        $this->notificationRepository = app(NotificationRepositoryInterface::class);
        $this->notificationRecipientRepository = app(NotificationRecipientRepositoryInterface::class);

        $this->notificationTemplate = $this->notificationRepository->findByType($notification_template);
        $this->variables = $variables;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
    /**
     * Get the message content definition.
     */
    public function toDatabase($notifiable)
    {
        $title = $this->notificationTemplate->title;
        $body = Blade::render($this->notificationTemplate->body, $this->variables);

        $this->notificationRecipientRepository->create([
            'user_id' => $notifiable->id,
            'notification_id' => $this->notificationTemplate->id,
            'status' => 'unread',
            'read_at' => null,
        ]);

        return [
            'user_id' => $notifiable->id,
            'notification_id' => $this->notificationTemplate->id,
            'status' => 'unread',
            'read_at' => null,
        ];
    }
}
