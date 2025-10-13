<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoryable extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id',
        'categoryable_id',
        'categoryable_type',
    ];
    protected $cast = [
        'category_id' => 'integer',
        'categoryable_id' => 'integer',
    ];
    public function category() : MorphToMany
    {
        return $this->morphedByMany(Category::class, 'categoryable');
    }
    public function product() : MorphToMany
    {
        return $this->morphedByMany(Product::class, 'categoryable');
    }
    public function blog() : MorphToMany
    {
        return $this->morphedByMany(Blog::class, 'categoryable');
    }
}
