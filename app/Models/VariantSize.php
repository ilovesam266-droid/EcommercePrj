<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;


class VariantSize extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'variant_sizes';

    protected $fillable = [
        'name',
        'size',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function productVariantSizes(): HasMany
    {
        return $this->hasMany(ProductVariantSize::class, 'variant_size_id');
    }
}
