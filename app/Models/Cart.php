<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\CartStatus;

class Cart extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='carts';
    protected $fillable=[
        'owner_id',
        'status',
    ];
    protected $casts=[
        'owner_id'=>'integer',
        'status'=>CartStatus::class,
    ];
    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id');
    }
    public function cartItems() : HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
