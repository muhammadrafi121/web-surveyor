<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tower extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function lands()
    {
        return $this->hasMany(Land::class)->orderBy('land_owner_id');
    }

    public function row()
    {
        return $this->hasOne(Row::class);
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
        return $this->hasMany(TowerHistory::class)->orderBy('updated', 'desc');
    }
}
