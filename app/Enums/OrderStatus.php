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

    public function colorClass(): string
    {
        return match ($this) {
            self::PENDING => 'bg-warning text-white',
            self::CONFIRMED => 'bg-info text-white',
            self::SHIPPING => 'bg-primary text-white',
            self::CANCELED => 'bg-secondary text-white',
            self::FAILED => 'bg-danger text-white',
            self::DONE => 'bg-success text-white',
        };
    }
}
