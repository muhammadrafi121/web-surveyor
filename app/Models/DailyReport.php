<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function lands()
    {
        return $this->belongsToMany(Land::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
