<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'created_by',
        'blog_id',
        'content',
    ];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function blog() : BelongsTo
    {
        return $this->belongsTo(Blog::class,'blog_id');
    }
}
