<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'shipping_fee',
        'province',
        'district',
        'ward',
        'detailed_address',
        'payment_method',
        'payment_status',
        'payment_transaction_code',
        'status',
        'customer_note',
        'admin_note',
    ];

    public $casts=[
        'shipping_fee' => 'integer',
        'total_amount'=>'integer',
        'payment_method' =>'integer',
        'payment_status' =>'integer',
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
