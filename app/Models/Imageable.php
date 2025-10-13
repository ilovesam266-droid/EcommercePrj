<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Imageable extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'image_id',
        'imageable_id',
        'imageable_type',
        'order_of_images',
        'is_primary',
    ];
    protected $casts = [
        'imageable_type' => 'integer',
        'is_primary' => 'boolean',
        'order_of_images' => 'integer',
    ];
    public function image() : MorphToMany
    {
        return $this->morphedByMany(Image::class, 'imageable');
    }
    public function users() : MorphToMany
    {
        return $this->morphedByMany(User::class, 'imageable');
    }
    public function products() : MorphToMany
    {
        return $this->morphedByMany(Product::class, 'imageable');
    }
}
