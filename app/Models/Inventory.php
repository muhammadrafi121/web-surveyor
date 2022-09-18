<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
