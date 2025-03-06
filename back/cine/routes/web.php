<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;

Route::get('/', function () {
    return view('index');
});

Route::get('/peliculas', [PeliController::class, 'index'])->name('peliculas.index'); 
Route::resource('sesiones', SessonController::class);    
Route::resource('tickets', TicketController::class);