<?php

namespace App\Listeners;

use App\Events\OrderConfirmed;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderConfirmedEmail implements ShouldQueue
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
    public function handle(OrderConfirmed $event): void
    {
        $this->mailService->sendOrderConfirmedMail($event->order);
    }
}
