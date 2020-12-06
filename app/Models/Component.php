<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'serial_number', 'model', 'manufacturer'];
    protected $perPage = 10;

    public function equipment()
    {
        return $this->belongsToMany(Component::class, 'component_equipment');
    }
}
