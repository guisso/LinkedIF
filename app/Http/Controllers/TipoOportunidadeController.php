<?php

namespace App\Http\Controllers;

use App\Models\TipoOportunidade;
use Illuminate\Http\Request;

/**
 * Controller para gerenciar tipos de oportunidade.
 */
class TipoOportunidadeController extends Controller
{
    /**
     * Lista todos os tipos de oportunidade.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $tipos = TipoOportunidade::all();

            return response()->json([
                'success' => true,
                'data' => $tipos->map(function ($tipo) {
                    return [
                        'id' => $tipo->id,
                        'nome' => $tipo->nome,
                    ];
                })
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar tipos de oportunidade.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

