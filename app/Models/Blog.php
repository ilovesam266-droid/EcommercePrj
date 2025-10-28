<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Blog extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'title',
        'body',
        'created_by',
    ];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class,'blog_id');
    }
    public function categories() : MorphToMany
    {
        return $this->morphToMany(Category::class,'categoryable');
    }
    public function images() : MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable')
                    ->withPivot('is_primary', 'order_of_images')
                    ->withTimestamps();
    }
}
