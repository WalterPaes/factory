<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Equipment extends Model
{
    protected $table = 'equipments';
    protected $fillable = ['name', 'description', 'status'];
    protected $casts = ['status' => 'boolean'];
    protected $appends = ['links'];
    protected $perPage = 10;

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function getLinksAttribute(): array
    {
        return [
            'self' => '/api/equipments/' . $this->id,
            'maintenances' => '/api/equipments/' . $this->id . '/maintenance'
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
