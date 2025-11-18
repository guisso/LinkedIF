<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidaturaController;
use App\Http\Controllers\CandidatoController;

Route::apiResource('candidaturas', CandidaturaController::class);
Route::apiResource('candidatos', CandidatoController::class);
