<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected array $fillable = ['start', 'end', 'description', 'equipment_id', 'user_id'];
    protected $perPage = 10;

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function equipment()
    {
        return $this->hasOne(Equipment::class);
    }
}
