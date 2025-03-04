<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;
use App\Http\Controllers\OrderController;


Route::post('/pelis', [PeliController::class, 'store']);
Route::post('/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');