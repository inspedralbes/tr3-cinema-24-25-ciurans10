<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;


Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/peliculas', [PeliController::class, 'index']); 
Route::get('/pelicula/{id}', [PeliController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/entradas', [TicketController::class, 'index']);
    Route::post('/entradas', [TicketController::class, 'store']);
    Route::get('/entradas/{id}', [TicketController::class, 'show']);
    Route::put('/entradas/{id}', [TicketController::class, 'update']);
    Route::delete('/entradas/{id}', [TicketController::class, 'destroy']);
});


Route::get('/butacas-ocupadas', [TicketController::class, 'obtenerButacasOcupadas']);