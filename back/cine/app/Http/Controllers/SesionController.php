<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SesionController extends Controller
{
    public function index()
    {
        
        return view('sesiones.index');
    }
}
