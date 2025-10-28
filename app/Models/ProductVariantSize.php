<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ProductVariantSize extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_size',
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

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($productVariantSize) {
            $product = $productVariantSize->product;
            $variantSize = $productVariantSize->variant_size;
            if ($product && $variantSize && empty($productVariantSize->sku)) {
                $productVariantSize->sku = $product->slug . '-' . strtoupper($variantSize);
            }
        });

        static::updating(function ($productVariantSize) {
            if($productVariantSize->stock < 0) {
                $productVariantSize->stock = 0;
            }
        });
    }


}
