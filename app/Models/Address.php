<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable=[
        'recipient_name',
        'recipient_phone',
        'province',
        'district',
        'ward',
        'detailed_address',
    ];

    public function addressUsers() : HasMany
    {
        return $this->hasMany(AddressUser::class,'address_id');
    }

}
