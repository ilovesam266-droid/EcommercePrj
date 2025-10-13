<?php

namespace App\Enums;

enum CartStatus : string
{
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
}
