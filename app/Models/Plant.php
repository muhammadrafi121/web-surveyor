<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function land()
    {
        return $this->belongsTo(Land::class);
    }
}
