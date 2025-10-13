<?php

namespace App\Enums;

enum PaymentStatus : string
{
    //pending, completed, failed, refunded
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
}
