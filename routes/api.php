<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Aqui ficam as rotas de API (JSON). O RouteServiceProvider já adiciona
| o prefixo '/api' automaticamente, então '/auth/login' vira '/api/auth/login'
*/

// ==================== ROTAS DE AUTENTICAÇÃO ====================

// Registro de novo usuário
Route::post('/auth/registro', [AuthController::class, 'registro'])->name('auth.registro');

// Login
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Ativação de conta
Route::post('/auth/ativar-conta', [AuthController::class, 'ativarConta'])->name('auth.ativar');

// Recuperação de senha
Route::post('/auth/solicitar-recuperacao-senha', [AuthController::class, 'solicitarRecuperacaoSenha'])->name('auth.solicitar-recuperacao');
Route::post('/auth/redefinir-senha', [AuthController::class, 'redefinirSenha'])->name('auth.redefinir-senha');

// ==================== ROTAS PROTEGIDAS (Requerem autenticação) ====================

Route::middleware('auth.token')->group(function () {
    // Logout
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    
    // Perfil do usuário autenticado
    Route::get('/auth/perfil', [AuthController::class, 'perfil'])->name('auth.perfil');
    
    // Renovar token
    Route::post('/auth/renovar-token', [AuthController::class, 'renovarToken'])->name('auth.renovar-token');
});

// ==================== ROTAS DE RECURSOS ====================

// O 'apiResource' cria automaticamente todas as rotas
// (index, show, store, update, destroy) para o CandidatoController.
Route::apiResource('candidatos', CandidatoController::class);

/*
Isso é o equivalente a escrever manualmente:
Route::get('/candidatos', [CandidatoController::class, 'index']);
Route::post('/candidatos', [CandidatoController::class, 'store']);
Route::get('/candidatos/{candidato}', [CandidatoController::class, 'show']);
Route::put('/candidatos/{candidato}', [CandidatoController::class, 'update']);
Route::delete('/candidatos/{candidato}', [CandidatoController::class, 'destroy']);
*/