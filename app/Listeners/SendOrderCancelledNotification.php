<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderCancelledNotification implements ShouldQueue
{
    use InteractsWithQueue;

    protected NotificationService $notificationService;

    public function __construct(NotificationService $notification_service)
    {
        $this->notificationService = $notification_service;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCancelled $event): void
    {
        $this->notificationService->sendOrderCancelledNotification($event->order);
    }
}
