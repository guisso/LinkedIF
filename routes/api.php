<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidaturaController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\AuthController;

Route::post('/registro', [AuthController::class, 'registro'])->name('auth.registro');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/ativar-conta', [AuthController::class, 'ativarConta'])->name('auth.ativar');
Route::post('/solicitar-recuperacao-senha', [AuthController::class, 'solicitarRecuperacaoSenha'])->name('auth.solicitar-recuperacao');
Route::post('/redefinir-senha', [AuthController::class, 'redefinirSenha'])->name('auth.redefinir-senha');

Route::middleware('auth:api')->group(function () {

    // Rotas de Autenticação Protegidas
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/perfil', [AuthController::class, 'perfil'])->name('auth.perfil');
    Route::post('/renovar-token', [AuthController::class, 'renovarToken'])->name('auth.renovar-token');

    // Rotas de Candidaturas (Movida para dentro do grupo protegido)
    Route::apiResource('candidaturas', CandidaturaController::class);
});

// Assumindo que a listagem de candidatos é pública
Route::apiResource('candidatos', CandidatoController::class);