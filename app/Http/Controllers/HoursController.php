<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HoursController extends Controller
{
    public function hours(){
        return view('hours');
    }
}
