<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'birthday',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function products() : HasMany
    {
        return $this->hasMany(Product::class,'created_by');
    }

    public function carts() : HasMany
    {
        return $this->hasMany(Cart::class,'owner_id');
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class,'owner_id');
    }
    public function addressUsers() : HasMany
    {
        return $this->hasMany(AddressUser::class,'user_id');
    }
    public function categories() : HasMany
    {
        return $this->hasMany(Category::class,'created_by');
    }
    public function payments() : HasMany
    {
        return $this->hasMany(Payment::class,'owner_id');
    }
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class,'user_id');
    }
    public function mails() : HasMany
    {
        return $this->hasMany(Mail::class,'user_id');
    }
    public function mailrecipients() : HasMany
    {
        return $this->hasMany(MailRecipient::class,'user_id');
    }
    public function notifications() : HasMany
    {
        return $this->hasMany(Notification::class,'user_id');
    }
    public function notificationrecipients() : HasMany
    {
        return $this->hasMany(NotificationRecipient::class,'user_id');
    }
    public function reviews() : HasMany
    {
        return $this->hasMany(Review::class,'user_id');
    }
}
