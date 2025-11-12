<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'created_by',
    ];

    protected $casts = [
        'created_by' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'created_by');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'categoryable');
    }

    public function blogs()
    {
        return $this->morphedByMany(Blog::class, 'categoryable');
    }


    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
