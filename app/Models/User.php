<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Support\Facades\Hash;
use DateTime;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $fillable = ['name', 'username', 'password'];
    protected $hidden = ['password'];
    protected $casts = ['status' => 'boolean'];
    protected $appends = ['links'];
    protected $perPage = 10;

    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function getLinksAttribute(): array
    {
        return [
            'self' => '/api/equipments/' . $this->id,
            'maintenances' => '/api/users/' . $this->id . '/maintenance'
        ];
    }

    public function getCreatedAtAttribute(string $date)
    {
        $date = new DateTime($date);
        return $date->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute(string $date)
    {
        $date = new DateTime($date);
        return $date->format('Y-m-d H:i:s');
    }
}
