<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory,
        HasApiTokens;

    public const ROLE_ROOT     = 'root';
    public const ROLE_ADMIN    = 'admin';
    public const ROLE_TEAMLEAD = 'teamlead';
    public const ROLE_BUYER    = 'buyer';

    public const ROLES_ALL = [
        self::ROLE_ROOT,
        self::ROLE_ADMIN,
        self::ROLE_TEAMLEAD,
        self::ROLE_BUYER,
    ];

    protected $fillable = [
        'login',
        'password',
        'role',
        'superior_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function superior(): BelongsTo
    {
        return $this->belongsTo(static::class);
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(static::class, 'superior_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'owner_id');
    }
}
