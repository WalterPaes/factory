<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';
    protected array $fillable = ['name', 'description', 'status'];
    protected $casts = ['status' => 'boolean'];
    protected $appends = ['links'];
    protected $perPage = 10;

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function getLinksAttribute(): array
    {
        return [
            'self' => '/api/equipments/' . $this->id,
            'maintenances' => '/api/equipments/' . $this->id . '/maintenance'
        ];
    }
}
