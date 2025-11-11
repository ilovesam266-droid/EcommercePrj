<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'recipient_name',
        'recipient_phone',
        'province',
        'district',
        'ward',
        'detailed_address',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted(){
        static::saving(function ($address){
            if($address->is_default){
                static::where('user_id', $address->user_id)
                ->where('id', '<>', $address->id)
                ->update(['is_default' => false]);
            }
        });
    }

    public function getFullAddressAttribute(): string
    {
        return "{$this->detailed_address}, {$this->ward}, {$this->district}, {$this->province}";
    }
}
