<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;
use App\Http\Controllers\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/pelis', [PeliController::class, 'index']);
Route::get('/pelicula/{id}', [PeliController::class, 'show']);
Route::post('/pelis', [PeliController::class, 'store']);