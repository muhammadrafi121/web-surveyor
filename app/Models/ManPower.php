<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManPower extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function dailyreport()
    {
        return $this->belongsTo(DailyReport::class);
    }
}
