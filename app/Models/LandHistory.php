<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function land()
    {
        return $this->belongsTo(Land::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
