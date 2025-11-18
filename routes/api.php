<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\CandidaturaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui são registradas as rotas da API. 
| O RouteServiceProvider carrega este arquivo e aplica o prefixo "api".
| Adicionamos um grupo "v1" para versionamento: /api/v1/...
|
*/

Route::prefix('v1')->group(function () {

     // ========================================================================
     // ROTAS PÚBLICAS (Não exigem login)
     // ========================================================================

     // Autenticação e Cadastro
     Route::post('/registro', [AuthController::class, 'registro'])->name('auth.registro');
     Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
     Route::post('/ativar-conta', [AuthController::class, 'ativarConta'])->name('auth.ativar');
     Route::post('/solicitar-recuperacao-senha', [AuthController::class, 'solicitarRecuperacaoSenha'])->name('password.request');
     Route::post('/redefinir-senha', [AuthController::class, 'redefinirSenha'])->name('password.reset');

     // Listagem Pública (Ex: Candidatos com currículo visível)
     Route::apiResource('candidatos', CandidatoController::class)->only(['index', 'show']);


     // ========================================================================
     // ROTAS PROTEGIDAS (Exigem Token Bearer)
     // ========================================================================

     Route::middleware('auth:sanctum')->group(function () {

          // Gestão da Conta
          Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
          Route::get('/perfil', [AuthController::class, 'perfil'])->name('auth.perfil');
          Route::post('/renovar-token', [AuthController::class, 'renovarToken'])->name('auth.refresh');

          // Candidaturas (Processo Seletivo)
          Route::apiResource('candidaturas', CandidaturaController::class)
               ->except(['index']); // Index é customizado abaixo

          // [Candidato] Ver histórico de candidaturas
          Route::get('/minhas-candidaturas', [CandidaturaController::class, 'minhas'])
               ->name('candidaturas.minhas');

          // [Editor/Empresa] Ver candidatos de uma vaga específica
          Route::get('/oportunidades/{oportunidadeId}/candidaturas', [CandidaturaController::class, 'porOportunidade'])
               ->name('candidaturas.por-oportunidade');

     });
});