<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected array $fillable = ['name', 'description', 'status'];
    protected $casts = ['status' => 'boolean'];
    protected $perPage = 10;

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }
}
