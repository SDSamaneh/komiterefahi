<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;


use App\Models\dashboard\Imprest;
use App\Models\dashboard\Maadiran;
use App\Models\dashboard\Service;
use App\Models\dashboard\Supervisor;
use App\Models\dashboard\Vam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'name',
        'email',
        'idCard',
        'phone_number',
        'password',
        'role',
        'supervisor_id'

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

    public function roles(): BelongsToMany
    {
        // اگر اسم جدول pivot چیز دیگری است، دومین پارامتر را تغییر بده
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }
 
    // آیا کاربر نقش مشخص را دارد؟ (به‌صورت کوئری، بدون بارگذاری کل کالکشن)
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    // آیا کاربر حداقل یکی از نقش‌های آرایه را دارد؟
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    // آیا کاربر همه‌ی نقش‌های آرایه را دارد؟
    public function hasAllRoles(array $roles): bool
    {
        $unique = array_unique($roles);
        $count = $this->roles()->whereIn('name', $unique)->count();
        return $count === count($unique);
    }

    public function vams()
    {
        return $this->hasMany(Vam::class, 'author_id');
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'author_id');
    }
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id');
    }
    public function maadiran()
    {
        return $this->belongsTo(Maadiran::class, 'author_id');
    }
    public function imprest()
    {
        return $this->belongsTo(Imprest::class, 'author_id');
    }
}
