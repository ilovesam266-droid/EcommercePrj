<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailRecipient extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'user_id',
        'mail_id',
        'email',
        'status',
        'sent_at',
        'error_message',
    ];
    protected $casts=[
        'status'=>'integer',
        'sent_at'=>'datetime',
    ];
    public function mail() : BelongsTo
    {
        return $this->belongsTo(Mail::class,'mail_id');
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
