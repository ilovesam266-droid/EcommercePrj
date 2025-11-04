<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\PaymentStatus;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'payment_method',
        'transaction_code',
        'status',
        'meta_data',
    ];
    protected $casts = [
        'amount' => 'integer',
        'status' => PaymentStatus::class,
        'payment_method' => PaymentMethod::class,
        'meta_data' => 'object',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function getStatusTextAttribute()
    // {
    //     return match ($this->status) {
    //         1 => 'Pending',
    //         2 => 'Processing',
    //         3 => 'Paid',
    //         4 => 'Failed',
    //         5 => 'Refunded',
    //         6 => 'Cancelled',
    //         default => 'Unknown',
    //     };
    // }
}
