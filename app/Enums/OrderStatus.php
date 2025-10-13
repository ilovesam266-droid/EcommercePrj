<?php

namespace App\Enums;

enum OrderStatus : string
{
    //pending, confirmed, shipping, canceled, failed, done
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case SHIPPING = 'shipping';
    case CANCELED = 'canceled';
    case FAILED = 'failed';
    case DONE = 'done';
}
