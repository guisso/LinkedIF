<?php

use Illuminate\Support\Facades\Route;
use App\Models\TipoOportunidade;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\CandidaturaController;


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

// CU04 - Tela de Publicar Oportunidade (deve vir ANTES da rota genérica)
Route::get('/oportunidades/publicar', function () {
    $tipos = TipoOportunidade::orderBy('nome')->get();

    return view('oportunidades.publicar', compact('tipos'));
})->name('oportunidades.publicar');

// Tela de Detalhes da Oportunidade (para candidatura)
Route::get('/oportunidades/{id}', [OportunidadeController::class, 'showWeb'])->name('oportunidades.show');

// Candidatura em uma oportunidade (aceita sessão web ou token)
Route::post('/oportunidades/{id}/candidatar', [CandidaturaController::class, 'storeWeb'])
    ->name('candidaturas.store');

// CU05 - Tela de Perfil do Usuário
Route::get('/perfil', function () {
    return view('perfis.perfil');
})->name('perfil');

// Tela de Sobre
Route::get('/sobre', function () {
    return view('_sobre.sobre');
})->name('_sobre.sobre');

