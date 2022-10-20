<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
    
    public function manPowers()
    {
        return $this->hasMany(ManPower::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lands()
    {
        return $this->belongsToMany(Land::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function histories()
    {
        return $this->hasMany(DailyReportHistory::class)->orderBy('updated', 'desc');
    }
}
