<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReportHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function dailyreport()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
