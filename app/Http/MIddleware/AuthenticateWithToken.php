<?php

namespace App\Http\Middleware;

use App\Models\Credencial;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para autenticação via token API.
 */
class AuthenticateWithToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pega o token do header Authorization
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token não fornecido.',
            ], 401);
        }

        // Busca a credencial pelo token
        $credencial = Credencial::where('api_token', $token)->first();

        if (!$credencial) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido.',
            ], 401);
        }

        // Verifica se o token expirou
        if ($credencial->token_expira_em && now()->greaterThan($credencial->token_expira_em)) {
            return response()->json([
                'success' => false,
                'message' => 'Token expirado.',
            ], 401);
        }

        // Verifica se a conta está ativa
        if (!$credencial->isAtivo()) {
            return response()->json([
                'success' => false,
                'message' => 'Conta inativa.',
            ], 403);
        }

        // Adiciona o usuário autenticado na requisição
        $request->setUserResolver(function () use ($credencial) {
            return $credencial;
        });

        return $next($request);
    }
}
