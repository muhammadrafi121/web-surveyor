<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rows()
    {
        return $this->hasMany(Location::class);
    }

    public function towers()
    {
        return $this->hasMany(Tower::class);
    }

    public function dailyreports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
