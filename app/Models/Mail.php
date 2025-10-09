<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
