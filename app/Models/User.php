<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
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
        'avatar',
        'role',
        'status',
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
            'role' => UserRole::class,
            'status' => UserStatus::class,
            'birthday' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn($value, $Attribute) => ucfirst($Attribute['first_name'] . ' ' . $Attribute['last_name'])
        );
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'created_by');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'owner_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'owner_id');
    }

    public function addresses(): HasMany
    {
        return $this->HasMany(Address::class, 'user_id');
    }

    public function categories()
    {
        return $this->morphMany(Category::class, 'categoryable');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'owner_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function mails(): HasMany
    {
        return $this->hasMany(Mail::class, 'created_by');
    }
    public function mailrecipients(): HasMany
    {
        return $this->hasMany(MailRecipient::class, 'user_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function notificationrecipients(): HasMany
    {
        return $this->hasMany(NotificationRecipient::class, 'user_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function createdImages()
    {
        return $this->hasMany(Image::class, 'created_by');
    }
}
