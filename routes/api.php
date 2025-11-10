<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidaturaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rotas do tipo API (stateless). As rotas aqui já recebem o prefixo /api
| automaticamente pelo kernel do Laravel.
|
*/

Route::apiResource('candidaturas', CandidaturaController::class);
