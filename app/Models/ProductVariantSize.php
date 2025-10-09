<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantSize extends Model
{
    use HasFactory, SoftDeletes;

   protected $fillable = [
        'product_id',
        'variant_size_id',
        'sku',
        'price',
        'total_sold',
        'stock',
    ];

    protected $casts = [
        'price' => 'integer',
        'total_sold' => 'integer',
        'stock' => 'integer',
    ];

    public function variantSize() : BelongsTo
    {
        return $this->belongsTo(VariantSize::class, 'variant_size_id');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($productVariantSize) {
            $product = $productVariantSize->product;
            $variantSize = $productVariantSize->variantSize;
            if ($product && $variantSize && empty($productVariantSize->sku)) {
                $productVariantSize->sku = $product->slug . '-' . strtoupper($variantSize->name);
            }
        });

        static::updating(function ($productVariantSize) {
            if($productVariantSize->stock < 0) {
                $productVariantSize->stock = 0;
            }
        });
    }


}
