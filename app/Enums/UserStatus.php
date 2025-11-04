<?php

namespace App\Enums;

enum UserStatus : string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function colorClass(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-success text-white',
            self::INACTIVE => 'bg-warning text-white',
        };
    }
}

