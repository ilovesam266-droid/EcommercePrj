<?php

namespace App\Models;

use App\Enums\MailType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'created_by',
        'title',
        'body',
        'type',
        'variables',
        'scheduled_at',
    ];
    protected $casts = [
        'type' => MailType::class,
        'variables' => 'array',
        'scheduled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function recipients(): HasMany
    {
        return $this->hasMany(MailRecipient::class, 'mail_id');
    }
}
