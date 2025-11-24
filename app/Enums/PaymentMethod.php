<?php

namespace App\Enums;

enum PaymentMethod : string
{
    //cash on delivery, credit card, paypal, bank transfer
    case CASH = 'cash on delivery';
    case CREDITCARD = 'credit card';
    case STRIPE = 'stripe';
    case PAYPAL = 'paypal';
    case BANKTRANSFER = 'bank transfer';

    public function colorClass(): string
    {
        return match ($this) {
            self::CASH => 'bg-success text-white',
            self::CREDITCARD => 'bg-primary text-white',
            self::STRIPE => 'bg-info text-white',
            self::BANKTRANSFER => 'bg-warning text-white',
        };
    }
}
