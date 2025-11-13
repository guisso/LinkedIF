<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

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