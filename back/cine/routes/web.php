<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SessionPeliController;
use App\Http\Controllers\TicketController;


Route::get('/', [AdminController::class, 'index'])->name('home');

Route::get('/peliculas', [PeliController::class, 'mostrarPeliculas'])->name('peliculas.index');
Route::get('/peliculas/create', [PeliController::class, 'create'])->name('peliculas.create');
Route::post('/peliculas', [PeliController::class, 'store'])->name('peliculas.store');
Route::put('/peliculas/{id}', [PeliController::class, 'update'])->name('peliculas.update');
Route::delete('/peliculas/{id}', [PeliController::class, 'destroy'])->name('peliculas.destroy');

Route::get('/sesiones', [SessionPeliController::class, 'mostrarSesiones'])->name('sesiones.index');
Route::post('/sesiones', [SessionPeliController::class, 'store'])->name('sesiones.store');
Route::put('/sesiones/{id}', [SessionPeliController::class, 'update'])->name('sesiones.update');
Route::delete('/sesiones/{id}', [SessionPeliController::class, 'destroy'])->name('sesiones.destroy');

Route::get('/tickets', [TicketController::class, 'mostrarTickets'])->name('tickets.index');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');      