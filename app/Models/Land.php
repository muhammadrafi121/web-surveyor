<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }

    public function dailyreports()
    {
        return $this->hasOne(DailyReport::class);
    }

    public function tower()
    {
        return $this->belongsTo(Tower::class);
    }

    public function row()
    {
        return $this->belongsTo(Row::class);
    }

    public function owner()
    {
        return $this->belongsTo(LandOwner::class, 'land_owner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(LandHistory::class)->orderBy('updated', 'desc');
    }
}
