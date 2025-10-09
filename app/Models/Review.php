<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table='reviews';
    protected $fillable=[
        'user_id',
        'product_id',
        'rating',
        'body',
    ];
    protected $casts=[
        'rating'=>'integer',
    ];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
