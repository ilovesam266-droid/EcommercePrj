<?php

namespace App\Listeners;

use App\Services\MailService;
use App\Events\OrderCancelled;
use App\Repository\Constracts\MailRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderCancelledEmail implements ShouldQueue
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
    public function handle(OrderCancelled $event): void
    {
        $this->mailService->sendOrderCancelledMail($event->order);
    }
}
