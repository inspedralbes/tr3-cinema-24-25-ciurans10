<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeliController;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('admin.panel') : redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login'); 
})->name('login');

Route::get('/home', function () {
    return view('home'); 
})->name('home');

Route::post('/login', [AuthController::class, 'loginAdmin'])->name('login.post');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');
});

Route::get('/peliculas', [PeliController::class, 'mostrarPeliculas'])->name('peliculas.index');
Route::post('/peliculas', [PeliController::class, 'store'])->name('peliculas.store');
Route::put('/peliculas/{id}', [PeliController::class, 'update'])->name('peliculas.update');
Route::delete('/peliculas/{id}', [PeliController::class, 'destroy'])->name('peliculas.destroy');

