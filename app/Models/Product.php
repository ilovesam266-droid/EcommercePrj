<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'created_by',
        'name',
        'slug',
        'description',
        'status',
    ];

    protected $casts = [
        'created_by' => 'integer',
        'status' => ProductStatus::class,
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function variant_sizes()
    {
        return $this->hasMany(ProductVariantSize::class, 'product_id');
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable')
            ->withPivot('is_primary', 'order_of_images')
            ->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->HasMany(Review::class, 'product_id');
    }

    public function averageRating(): float
    {
        return $this->reviews->avg('rating') ?? 0;
    }

    public function sumStock(): int
    {
        return $this->variant_sizes()->sum('stock') ?? 0;
    }

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function stockStatus()
    {
        $stock = $this->sumStock();

        if ($stock === 0) {
            return [
                'label' => 'Out of stock',
                'class' => 'text-danger',
                'dot'   => '●', // red dot
            ];
        }

        if ($stock < 10) {
            return [
                'label' => 'Low stock',
                'class' => 'text-warning',
                'dot'   => '●', // yellow dot
            ];
        }

        return [
            'label' => 'In stock',
            'class' => 'text-success',
            'dot'   => '●', // green dot
        ];
    }
}
