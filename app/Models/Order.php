<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable=[
        'owner_by',
        'total_amount',
        'recipient_name',
        'recipient_phone',
        'province',
        'district',
        'ward',
        'detailed_address',
        'payment_method',
        'status',
    ];

    public $casts=[
        'total_amount'=>'integer',
        'status'=>OrderStatus::class,
        'owner_by'=>'integer',
    ];

    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class,'owner_by');
    }
    public function orderItems() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payment() : HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
