<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Equipment extends Model
{
    protected $table = 'equipments';
    protected $fillable = ['name', 'description', 'status', 'localization'];
    protected $casts = ['status' => 'boolean'];
    protected $appends = ['links'];
    protected $perPage = 10;

    public static function saveComponent(int $equipment_id, int $component_id)
    {
        return DB::table('component_equipment')->insert([
            'equipment_id' => $equipment_id,
            'component_id' => $component_id
        ]);
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
            'maintenances' => '/api/equipments/' . $this->id . '/maintenance',
            'components' => '/api/equipments/' . $this->id . '/components'
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
