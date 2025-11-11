<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancelledNotification extends BaseNotificationTemplate implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        parent::__construct('order_canceled', [
            'order_id' => $order->id,
            'cancelled_at' => now()->format('d/m/Y H:i'),
            'cancel_reason' => $order->cancel_reason ?? 'Customer request',
        ]);
    }
}
