<?php

namespace App\Enums;

enum CommentStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function colorClass(): string
    {
        return match($this) {
            self::PENDING => 'bg-info text-white',
            self::APPROVED => 'bg-success text-white',
            self::REJECTED => 'bg-warning text-white',
        };
    }

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
        };
    }
}
