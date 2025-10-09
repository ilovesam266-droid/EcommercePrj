<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable=[
        'order_id',
        'product_variant_size_id',
        'quantity',
        'unit_price',
    ];
    public $casts=[
        'quantity'=>'integer',
        'unit_price'=>'integer',
    ];
    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function productVariantSize() : BelongsTo
    {
        return $this->belongsTo(ProductVariantSize::class);
    }
    public function getTotalPriceAttribute() : int
    {
        return $this->quantity * $this->unit_price;
    }
}
