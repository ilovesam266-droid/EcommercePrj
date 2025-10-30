<?php

namespace App\Enums;

enum PaymentMethod : string
{
    //cash on delivery, credit card, paypal, bank transfer
    case CASH = 'cash on delivery';
    case CREDITCARD = 'credit card';
    case PAYPAL = 'paypal';
    case BANKTRANSFER = 'bank transfer';
}
