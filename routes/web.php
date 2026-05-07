<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FichaAcessoController;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest', 'guest.clinica'])->group(function () {
    Route::view('/login', 'login')->name('login');
    Route::view('/register', 'register')->name('register');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.tutor_ou_clinica')->name('logout');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

    Route::get('/consultas/create', [ConsultaController::class, 'create'])->name('consultas.create');
    Route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');
});

Route::middleware(['auth.tutor_ou_clinica'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/consultas', [ConsultaController::class, 'index'])->name('consultas.index');
    Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show');
    Route::get('/pets/{pet}/pdf', [PetController::class, 'pdf'])->name('pets.pdf');
    Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::patch('/pets/{pet}', [PetController::class, 'update']);
});

Route::middleware(['auth:clinica'])->group(function () {
    Route::get('/ficha/desbloquear', [FichaAcessoController::class, 'create'])->name('ficha.create');
    Route::post('/ficha/desbloquear', [FichaAcessoController::class, 'store'])->name('ficha.store');
    Route::post('/consultas/{id}/aceitar', [ConsultaController::class, 'aceitar'])->name('consultas.aceitar');
    Route::post('/consultas/{id}/recusar', [ConsultaController::class, 'recusar'])->name('consultas.recusar');
});
