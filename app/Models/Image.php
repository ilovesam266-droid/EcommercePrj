<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory, softDeletes;
    protected $fillable = [
        'created_by',
        'url',
        'image_name',
    ];
    protected $casts = [
        'created_by' => 'integer',
    ];

    public function products()
    {
        return $this->morphedByMany(Product::class, 'imageable')
                    ->withPivot('is_primary', 'order_of_images')
                    ->withTimestamps();
    }

    public function blogs()
    {
        return $this->morphedByMany(Blog::class, 'imageable')
                    ->withPivot('is_primary', 'order_of_images')
                    ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
