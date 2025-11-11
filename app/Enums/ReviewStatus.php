<?php

namespace App\Enums;

enum ReviewStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    // Lấy CSS class tương ứng
    public function colorClass(): string
    {
        return match($this) {
            self::Pending => 'bg-info text-white',
            self::Approved => 'bg-success text-white',
            self::Rejected => 'bg-warning text-white',
        };
    }
}
