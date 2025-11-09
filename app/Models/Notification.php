<?php

namespace App\Models;

use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'created_by',
        'title',
        'body',
        'type',
        'variables',
        'scheduled_at',
    ];
    protected $casts=[
        'type' => NotificationType::class,
        'variables' => 'array',
        'scheduled_at' => 'datetime',
    ];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function recipients(): HasMany
    {
        return $this->hasMany(MailRecipient::class, 'mail_id');
    }
}
