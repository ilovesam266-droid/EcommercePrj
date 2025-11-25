<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable=[
        'owner_id',
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
        'canceled_at',
    ];

    public $casts=[
        'shipping_fee' => 'integer',
        'total_amount'=>'integer',
        'payment_method' =>'integer',
        'payment_status' =>'integer',
        'status'=>OrderStatus::class,
        'owner_by'=>'integer',
    ];

    public const PAYMENT_METHODS = [
        0 => 'Cash on Delivery',
        1 => 'Credit Card',
        2 => 'E-wallet',
        3 => 'Bank Transfer',
    ];

    public const PAYMENT_STATUSES = [
        0 => 'Pending',
        1 => 'Paid',
        2 => 'Failed',
    ];

    public function updateOrderTotal()
    {
        if ($this->order) {
            $total = $this->order->orderItems()
                ->sum('quantity * unit_price');

            $this->order->update(['total_amount' => $total]);
        }
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->total_amount, 0, ',', '.') . ' ₫';
    }

    public function getFormattedShippingFeeAttribute()
    {
        return number_format($this->shipping_fee, 0, ',', '.') . ' ₫';
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount - $this->shipping_fee, 0, ',', '.') . ' ₫';
    }

    protected function fulladdress() : Attribute
    {
        return Attribute::make(
            get: fn($value, $Attribute) => ucfirst($Attribute['detailed_address'] . ', ' . $Attribute['ward'].', '.$Attribute['district'].', '.$Attribute['province'])
        );
    }

    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id');
    }
    public function orderItems() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payment() : HasOne
    {
        return $this->hasOne(Payment::class);
    }
    public function review() : HasMany{
        return $this->hasMany(Review::class, 'order_id');
    }
}
