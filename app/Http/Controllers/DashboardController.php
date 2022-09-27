<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tower;
use App\Models\Row;

class DashboardController extends Controller
{
    public function index()
    {
        $row = Row::all()->count();
        $tower = Tower::all()->count();
        return view('dashboard', [
            'title' => 'Dashboard',
            'row' => $row,
            'tower' => $tower,
            'script' => 'dashboard',
        ]);
    }
}
