<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationRecipient extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='notification_recipients';
    protected $fillable=[
        'notification_id',
        'user_id',
        'email',
        'status',
        'error_message',
        'sent_at',
    ];
    protected $casts=[
        'status'=>'integer',
        'sent_at'=>'datetime',
    ];
    public function notification() : BelongsTo
    {
        return $this->belongsTo(Notification::class,'notification_id');
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
