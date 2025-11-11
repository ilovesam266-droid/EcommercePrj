<?php

namespace App\Services;

use App\Notifications\OrderCancelledNotification;
use App\Repository\Constracts\NotificationRecipientRepositoryInterface;
use App\Repository\Constracts\NotificationRepositoryInterface;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected NotificationRepositoryInterface $notificationRepository;
    protected NotificationRecipientRepositoryInterface $notificationRecipientRepository;
    public function __construct(NotificationRepositoryInterface $notification_repository, NotificationRecipientRepositoryInterface $notification_recipient_repository)
    {
        $this->notificationRepository = $notification_repository;
        $this->notificationRecipientRepository = $notification_recipient_repository;
    }

    public function sendOrderCancelledNotification($order): void
    {
        $recipient = $order->owner;

        try{
            $recipient->notify(new OrderCancelledNotification($order));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            }
    }
}
