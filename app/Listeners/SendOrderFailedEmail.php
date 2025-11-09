<?php

namespace App\Listeners;

use App\Events\OrderFailed;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderFailedEmail implements ShouldQueue
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
    public function handle(OrderFailed $event): void
    {
        $this->mailService->sendOrderFailedMail($event->order);
    }
}
