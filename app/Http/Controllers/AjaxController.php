<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function inventory(Request $request)
    {
        return Inventory::with('locations')->where('id', $request->id)->get();
    }
}
