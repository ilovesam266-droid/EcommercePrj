<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class Image extends Model
{
    use Factory, softDeletes;
    protected $fillable = [
        'url',
        'order_of_images',
        'is_primary',
    ];
    protected $casts = [
        'is_primary' => 'boolean',
        'order_of_images' => 'integer',
    ];

    public function imagable()
    {
        return $this->morphedByMany();
    }
}
