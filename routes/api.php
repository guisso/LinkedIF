<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| O RouteServiceProvider já adiciona o prefixo '/api'.
*/

// ==================== ROTAS DE AUTENTICAÇÃO (Públicas) ====================
// Estas rotas não precisam do prefixo /auth, são a raiz da autenticação.
// Isso corrige o seu 404 Not Found em /api/registro.

Route::post('/registro', [AuthController::class, 'registro'])->name('auth.registro');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/ativar-conta', [AuthController::class, 'ativarConta'])->name('auth.ativar');
Route::post('/solicitar-recuperacao-senha', [AuthController::class, 'solicitarRecuperacaoSenha'])->name('auth.solicitar-recuperacao');
Route::post('/redefinir-senha', [AuthController::class, 'redefinirSenha'])->name('auth.redefinir-senha');

// ==================== ROTAS PROTEGIDAS (Requerem autenticação) ====================

// Corrigido: 'auth:api' é o middleware padrão do Laravel para APIs.
// 'auth.token' não é padrão e exigiria configuração extra.
// O Laravel agora protegerá este grupo e injetará o usuário no Request.
Route::middleware('auth:api')->group(function () {

    // As rotas aqui dentro também não precisam do prefixo /auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/perfil', [AuthController::class, 'perfil'])->name('auth.perfil');
    Route::post('/renovar-token', [AuthController::class, 'renovarToken'])->name('auth.renovar-token');

    // NOTA: Se 'candidatos' também for protegido, mova-o para cá
    // Route::apiResource('candidatos', CandidatoController::class);
});

// ==================== ROTAS DE RECURSOS (Públicas) ====================

// Se esta rota for pública (qualquer um pode ver), deixe aqui.
// Se for protegida, mova-a para dentro do 'middleware' acima.
Route::apiResource('candidatos', CandidatoController::class);

/*
Isso é o equivalente a escrever manualmente:
Route::get('/candidatos', [CandidatoController::class, 'index']);
Route::post('/candidatos', [CandidatoController::class, 'store']);
Route::get('/candidatos/{candidato}', [CandidatoController::class, 'show']);
Route::put('/candidatos/{candidato}', [CandidatoController::class, 'update']);
Route::delete('/candidatos/{candidato}', [CandidatoController::class, 'destroy']);
*/