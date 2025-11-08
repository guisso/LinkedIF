<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// ==================== ROTAS DE AUTENTICAÇÃO ====================

// Registro de novo usuário
Route::post('/api/auth/registro', [AuthController::class, 'registro'])->name('auth.registro');

// Login
Route::post('/api/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Ativação de conta
Route::post('/api/auth/ativar-conta', [AuthController::class, 'ativarConta'])->name('auth.ativar');

// Recuperação de senha
Route::post('/api/auth/solicitar-recuperacao-senha', [AuthController::class, 'solicitarRecuperacaoSenha'])->name('auth.solicitar-recuperacao');
Route::post('/api/auth/redefinir-senha', [AuthController::class, 'redefinirSenha'])->name('auth.redefinir-senha');

// ==================== ROTAS PROTEGIDAS (Requerem autenticação) ====================

Route::middleware('auth:api')->group(function () {
    // Logout
    Route::post('/api/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    
    // Perfil do usuário autenticado
    Route::get('/api/auth/perfil', [AuthController::class, 'perfil'])->name('auth.perfil');
    
    // Renovar token
    Route::post('/api/auth/renovar-token', [AuthController::class, 'renovarToken'])->name('auth.renovar-token');
});
