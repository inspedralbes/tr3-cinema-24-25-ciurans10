<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeliController;
use App\Http\Controllers\SessionPeliController;
use App\Http\Controllers\TicketController;


Route::get('/', function () {
    return redirect()->route('admin.panel');
});

Route::get('/home', [AdminController::class, 'index'])->name('home');

Route::get('/peliculas', [PeliController::class, 'mostrarPeliculas'])->name('peliculas.index');
Route::post('/peliculas', [PeliController::class, 'store'])->name('peliculas.store');
Route::put('/peliculas/{id}', [PeliController::class, 'update'])->name('peliculas.update');
Route::delete('/peliculas/{id}', [PeliController::class, 'destroy'])->name('peliculas.destroy');
