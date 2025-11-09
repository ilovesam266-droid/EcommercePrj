<?php

namespace App\Listeners;

use App\Events\OrderShipping;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderShippingEmail implements ShouldQueue
{
    use InteractsWithQueue;

    protected MailService $mailService;
    public function __construct(MailService $mail_service)
    {
        $this->mailService = $mail_service;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderShipping $event): void
    {
        $this->mailService->sendOrderShippingMail($event->order);
    }
}
