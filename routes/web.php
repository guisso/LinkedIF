<?php

use Illuminate\Support\Facades\Route;

// ==================== ROTAS DE VISUALIZAÇÃO (WEB) ====================

Route::get('/', function () {
    return redirect()->route('login.form');
});

// Tela de login
Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');

// Tela de registro
Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');
