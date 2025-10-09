<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'method',
        'transaction_code',
        'status', 
        'meta_data',
    ];
    protected $casts = [
        'amount' => 'integer',
        'status' => 'integer',
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

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            1 => 'Pending',
            2 => 'Processing',
            3 => 'Paid',
            4 => 'Failed',
            5 => 'Refunded',
            6 => 'Cancelled',
            default => 'Unknown',
        };
    }
}
