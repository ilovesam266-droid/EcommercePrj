<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagable extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'image_id',
        'imagable_id',
        'imagable_type',
    ];
    public function image() : BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
    public function imagable() : MorphTo
    {
        return $this->morphTo();
    }
}
