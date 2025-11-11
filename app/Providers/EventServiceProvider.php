<?php

namespace App\Providers;

use App\Events\OrderConfirmed;
use App\Listeners\SendOrderConfirmedEmail;
use App\Events\OrderCancelled;
use App\Events\OrderDone;
use App\Events\OrderFailed;
use App\Events\OrderShipping;
use App\Listeners\SendOrderCancelledEmail;
use App\Listeners\SendOrderCancelledNotification;
use App\Listeners\SendOrderDoneEmail;
use App\Listeners\SendOrderFailedEmail;
use App\Listeners\SendOrderShippingEmail;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        OrderCancelled::class => [
            SendOrderCancelledEmail::class,
            SendOrderCancelledNotification::class,
        ],
        OrderConfirmed::class => [
            SendOrderConfirmedEmail::class,
        ],
        OrderShipping::class => [
            SendOrderShippingEmail::class,
        ],
        OrderFailed::class => [
            SendOrderFailedEmail::class,
        ],
        OrderDone::class => [
            SendOrderDoneEmail::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
