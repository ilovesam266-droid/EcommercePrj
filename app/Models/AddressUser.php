<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddressUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'address_id',
        'is_default',
    ];

    public function address() : BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
