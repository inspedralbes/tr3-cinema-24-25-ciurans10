<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;

Route::get('/pelis', [PeliController::class, 'index']);
Route::post('/pelis', [PeliController::class, 'store']);