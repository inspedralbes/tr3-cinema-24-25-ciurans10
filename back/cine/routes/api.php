<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;


Route::post('/pelis', [PeliController::class, 'store']);
