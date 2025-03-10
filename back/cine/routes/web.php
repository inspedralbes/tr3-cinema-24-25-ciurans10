<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\TicketController;


Route::get('/', [AdminController::class, 'index']);
Route::get('/peliculas', [PeliController::class, 'mostrarPeliculas'])->name('peliculas.index');
Route::get('/sesiones', [SesionController::class, 'index'])->name('sesiones.index');
Route::get('/tickets', [SesionController::class, 'index'])->name('tickets.index');  