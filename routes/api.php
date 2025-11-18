<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\CandidaturaController;

Route::prefix('v1')->group(function () {

    //ROTAS PÚBLICAS
    Route::post('/registro', [AuthController::class, 'registro']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/ativar-conta', [AuthController::class, 'ativarConta']);
    Route::post('/solicitar-recuperacao-senha', [AuthController::class, 'solicitarRecuperacaoSenha']);
    Route::post('/redefinir-senha', [AuthController::class, 'redefinirSenha']);

    // Candidatos são públicos (currículo aberto)
    Route::apiResource('candidatos', CandidatoController::class)->only(['index', 'show']);


    //ROTAS AUTENTICADAS
    Route::middleware('auth:sanctum')->group(function () {

        // Auth & Perfil
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/perfil', [AuthController::class, 'perfil']);
        Route::post('/renovar-token', [AuthController::class, 'renovarToken']);

        //CANDIDATURAS
        Route::apiResource('candidaturas', CandidaturaController::class)
             ->except(['index']); // vamos controlar index manualmente

        // Candidato vê suas próprias candidaturas
        Route::get('/minhas-candidaturas', [CandidaturaController::class, 'minhas'])
             ->name('candidaturas.minhas');

        // Editor vê candidaturas de uma oportunidade específica
        Route::get('/oportunidades/{oportunidadeId}/candidaturas', [CandidaturaController::class, 'porOportunidade'])
             ->name('candidaturas.por-oportunidade');

    });
});