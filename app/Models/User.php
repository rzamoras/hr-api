<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed $username
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $middle_name
 * @property mixed $name_ext
 * @property mixed $password
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'first_name',
        'last_name',
        'middle_name',
        'name_ext',
        'email',
        'office_code',
        'section_code',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function office(): HasOne
    {
        return $this->hasOne(Office::class, 'code', 'office_code');
    }

    protected $appends = [
        'full_name',
        'is_first_login',
        'is_deleted'
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->first_name . " " . $this->last_name,
        );
    }

    protected function isFirstLogin(): Attribute
    {
        return Attribute::make(
            get: fn() => Hash::check('password123', $this->password),
        );
    }

    protected function isDeleted(): Attribute
    {
        return Attribute::make(
            get: fn() => (bool)$this->deleted_at,
        );
    }
}
