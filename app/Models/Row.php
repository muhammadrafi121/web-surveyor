<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function lands()
    {
        return $this->hasMany(Land::class)->orderBy('land_owner_id');
    }

    public function firsttower()
    {
        return $this->belongsTo(Tower::class, 'tower1_id');
    }
    
    public function secondtower()
    {
        return $this->belongsTo(Tower::class, 'tower2_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(RowHistory::class)->orderBy('updated', 'desc');
    }
}
