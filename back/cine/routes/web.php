<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;

Route::get('/', function () {
    return view('index');
});

Route::resource('peliculas', PeliController::class); 
Route::resource('sesiones', SessonController::class);    
Route::resource('tickets', TicketController::class);    