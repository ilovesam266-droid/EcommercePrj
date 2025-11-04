<?php

namespace App\Enums;

enum UserRole : string
{
    case USER = 'user';
    case ADMIN = 'admin';

    public function colorClass(): string
    {
        return match ($this) {
            self::USER => 'bg-secondary text-white',
            self::ADMIN => 'bg-danger text-white',
        };
    }
}
