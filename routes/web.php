<?php

use Illuminate\Support\Facades\Route;

// Rota raiz: Manda diretamente para o login (sem middleware)
Route::get('/', function () {
    return view('auth.login');
});

// Tela de Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');

// Tela de Cadastro
Route::get('/cadastro', function () {
    return view('auth.register');
})->name('register.form');

// Tela de Dashboard (HOME)
Route::get('/home', function () {
    return view('dashboard');
})->name('home');

// CU04 - Tela de Publicar Oportunidade
Route::get('/oportunidades/publicar', function () {
    return view('oportunidades.publicar');
})->name('oportunidades.publicar');