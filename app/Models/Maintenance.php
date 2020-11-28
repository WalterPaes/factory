<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected array $fillable = ['start', 'end', 'description', 'equipment_id', 'user_id'];
    protected $perPage = 10;
    protected $appends = ['links'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function equipment()
    {
        return $this->hasOne(Equipment::class);
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
            'self' => '/api/maintenance/' . $this->id,
            'equipment' => '/api/equipment/' . $this->equipment_id,
            'user' => '/api/user/' . $this->user_id
        ];
    }
}
