<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'owner_id',
        'total_amount',
        'recipient_name',
        'recipient_phone',
        'shipping_fee',
        'province',
        'district',
        'ward',
        'detailed_address',
        'status',
        'customer_note',
        'admin_note',
        'canceled_at',
    ];

    public $casts = [
        'shipping_fee' => 'integer',
        'total_amount' => 'integer',
        'status' => OrderStatus::class,
        'owner_by' => 'integer',
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

    public function validateStatusChange(string $newStatus): ?string
    {
        $paymentMethod = $this->payment->payment_method ?? null;
        $paymentStatus = $this->payment->status ?? null;

        // CASE 1 — COD
        if ($paymentMethod === 'cod') {
            if ($newStatus === OrderStatus::DONE && $paymentStatus !== PaymentStatus::COMPLETED) {
                return 'COD order cannot be marked as DONE until payment is collected.';
            }
            return null;
        }

        // CASE 2 — online payment
        if ($paymentStatus === PaymentStatus::FAILED && $newStatus !== OrderStatus::CANCELED) {
            return 'Order with failed payment can only be cancelled.';
        }

        if ($paymentStatus !== PaymentStatus::COMPLETED) {
            if (in_array($newStatus, [OrderStatus::CONFIRMED, OrderStatus::SHIPPING, OrderStatus::DONE], true)) {
                return 'Cannot update status. Online order must be paid first.';
            }
        }

        return null;
    }

    public function updateStatus(string $newStatus): bool|string
    {
        if ($error = $this->validateStatusChange($newStatus)) {
            return $error;
        }

        $this->status = $newStatus;
        $this->save();

        return true;
    }

    protected static function booted()
    {
        static::updating(function ($order) {

            $oldStatus = $order->getOriginal('status');
            $newStatus = $order->status;

            $paymentMethod = $order->payment_method;
            $paymentStatus = $order->payment_status;

            /*
        |--------------------------------------------------------------------------
        | 1. COD — NO PREPAYMENT REQUIRED
        |--------------------------------------------------------------------------
        */
            if ($paymentMethod === PaymentMethod::CASH) {

                // Admin may only mark DONE if payment has been collected
                if ($newStatus === OrderStatus::DONE && $paymentStatus !== PaymentMethod::CASH) {
                    // throw new \Exception("COD order cannot be marked as DONE until payment is collected.");
                    return "COD order cannot be marked as DONE until payment is collected.";
                }

                // Switching to FAILED is always valid (customer didn't pay)
                return;
            }

            /*
        |--------------------------------------------------------------------------
        | 2. ONLINE PAYMENT — MUST BE PAID FIRST
        |--------------------------------------------------------------------------
        */

            // If payment failed → only allow changing to cancelled
            if ($paymentStatus === PaymentStatus::FAILED && $newStatus !== OrderStatus::CANCELED) {
                // throw new \Exception("Order with failed payment can only be cancelled.");
                return "Order with failed payment can only be cancelled.";
            }

            // If not paid yet → do not allow confirm, shipping, done
            if ($paymentStatus !== PaymentStatus::COMPLETED) {
                if (in_array($newStatus, [OrderStatus::CONFIRMED, OrderStatus::SHIPPING, OrderStatus::DONE])) {
                    // throw new \Exception("Cannot update status. Online order must be paid first.");
                    return "Cannot update status. Online order must be paid first.";
                }
            }

            // If paid → admin has full control
            if ($paymentStatus === PaymentStatus::COMPLETED) {
                return;
            }
        });
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

    protected function fulladdress(): Attribute
    {
        return Attribute::make(
            get: fn($value, $Attribute) => ucfirst($Attribute['detailed_address'] . ', ' . $Attribute['ward'] . ', ' . $Attribute['district'] . ', ' . $Attribute['province'])
        );
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
    public function review(): HasMany
    {
        return $this->hasMany(Review::class, 'order_id');
    }
}
