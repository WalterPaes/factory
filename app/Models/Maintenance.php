<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Maintenance extends Model
{
    public $timestamps = false;
    protected $fillable = ['start', 'end', 'description', 'equipment_id', 'user_id'];
    protected $perPage = 10;
    protected $appends = ['links'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function getUserAttribute()
    {
        $user = User::find($this->user_id);
        return $user->name;
    }

    public function getEquipmentAttribute()
    {
        $equipment = Equipment::find($this->equipment_id);
        return $equipment->name;
    }

    public function getLinksAttribute(): array
    {
        return [
            'self' => '/api/maintenances/' . $this->id,
            'equipment' => '/api/equipments/' . $this->equipment_id,
            'user' => '/api/users/' . $this->user_id
        ];
    }

    public function getStartAttribute(string $date)
    {
        $date = new DateTime($date);
        return $date->format('Y-m-d H:i:s');
    }

    public function setStartAttribute(string $date)
    {
        $date = new DateTime($date);
        $this->attributes['start'] = $date->format('Y-m-d H:i:s');
    }

    public function getEndAttribute(string $date)
    {
        $date = new DateTime($date);
        return $date->format('Y-m-d H:i:s');
    }

    public function setEndAttribute(string $date)
    {
        $date = new DateTime($date);
        $this->attributes['end'] = $date->format('Y-m-d H:i:s');
    }
}
