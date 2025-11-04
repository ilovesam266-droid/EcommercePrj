<?php

namespace App\Enums;

enum ProductStatus : string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case REJECTED = 'rejected';

    public function colorClass(): string
    {
        return match ($this) {
            self::INACTIVE => 'bg-warning text-white',
            self::ACTIVE => 'bg-primary text-white',
            self::REJECTED => 'bg-danger text-white',
            self::PENDING => 'bg-success text-white',
        };
    }
}
