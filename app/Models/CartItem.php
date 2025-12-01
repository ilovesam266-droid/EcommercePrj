<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'cart_id',
        'product_variant_size_id',
        'quantity',
    ];
    protected $casts=[
        'quantity'=>'integer',
    ];

    public function cart() : BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function productVariantSize() : BelongsTo
    {
        return $this->belongsTo(ProductVariantSize::class, 'product_variant_size_id');
    }
}
