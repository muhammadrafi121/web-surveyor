<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    use HasFactory;

    public function lands()
    {
        return $this->hasMany(Land::class);
    }

    public function firsttowers()
    {
        return $this->belongsToMany(Tower::class, 'tower1_id');
    }
    
    public function secondtowers()
    {
        return $this->belongsToMany(Tower::class, 'tower2_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
