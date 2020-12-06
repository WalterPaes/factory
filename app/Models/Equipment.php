<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';
    protected $fillable = ['name', 'description', 'status', 'localization'];
    protected $casts = ['status' => 'boolean'];
    protected $appends = ['links'];
    protected $perPage = 10;

    public static function create(array $data)
    {
        $equipment = new Equipment;
        $equipment->name = $data['name'];
        $equipment->description = $data['description'];
        $equipment->localization = $data['localization'];
        //$equipment->components()->attach($data['components']);
        return $equipment->save();
    }

    public static function edit(int $id, array $data)
    {
        $equipment = self::find($id);
        $equipment->name = $data['name'];
        $equipment->description = $data['description'];
        $equipment->status = $data['status'];
        $equipment->localization = $data['localization'];
        $equipment->components()->sync($data['components']);
        return $equipment->save();
    }

    public static function actives()
    {
        return self::where('status', true)
            ->get();
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function components()
    {
        return $this->belongsToMany(Component::class, 'component_equipment');
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
