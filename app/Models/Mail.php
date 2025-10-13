<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'created_by',
        'title',
        'body',
        'variables',
    ];
    protected $casts=[
        'variables'=>'object',
    ];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function recipients() : HasMany
    {
        return $this->hasMany(NotificationRecipient::class,'notification_id');
    }
}
