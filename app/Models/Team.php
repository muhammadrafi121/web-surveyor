<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function dailyreports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function members()
    {
        return $this->hasMany(TeamMember::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
