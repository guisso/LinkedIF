<?php

namespace App\Http\Controllers;

use App\Models\Credencial;
use App\Models\Usuario;
use App\Models\Enums\TipoPerfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Controller responsável pela autenticação de usuários.
 * Gerencia registro, login, logout e operações relacionadas a tokens.
 */
class AuthController extends Controller
{
    /**
     * Registra um novo usuário no sistema.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registro(Request $request)
    {
        // Validação dos dados de entrada
        $validador = Validator::make($request->all(), [
            'nome' => 'required|string|max:45',
            'email' => 'required|email|max:250|unique:usuarios,email',
            'telefone' => 'required|string|max:16',
            'nascimento' => 'required|date',
            'nome_usuario' => 'required|string|max:20|unique:credenciais,nome_usuario',
            'senha' => 'required|string|min:6',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'E-mail inválido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'telefone.required' => 'O telefone é obrigatório.',
            'nascimento.required' => 'A data de nascimento é obrigatória.',
            'nascimento.date' => 'Data de nascimento inválida.',
            'nome_usuario.required' => 'O nome de usuário é obrigatório.',
            'nome_usuario.unique' => 'Este nome de usuário já está em uso.',
            'nome_usuario.max' => 'O nome de usuário deve ter no máximo 20 caracteres.',
            'senha.required' => 'A senha é obrigatória.',
            'senha.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação.',
                'errors' => $validador->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Calcular idade
            $nascimento = new \DateTime($request->nascimento);
            $hoje = new \DateTime();
            $idade = $hoje->diff($nascimento)->y;

            // Cria o usuário
            $usuario = new Usuario();
            $usuario->setNome($request->nome);
            $usuario->setEmail($request->email);
            $usuario->setTelefone($request->telefone);
            $usuario->setWhatsApp($request->whatsapp ?? false);
            $usuario->setNascimento(\Carbon\Carbon::parse($request->nascimento));
            $usuario->setIdade($idade);
            $usuario->save();

            // Cria a credencial vinculada ao usuário
            $credencial = new Credencial();
            $credencial->usuario_id = $usuario->getId();
            $credencial->setNomeUsuario($request->nome_usuario);
            $credencial->setSenha(Hash::make($request->senha));
            $credencial->setTipoPerfil(TipoPerfil::CANDIDATO);
            $credencial->setAtivo(false); 
            $credencial->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cadastro realizado com sucesso!',
                'data' => [
                    'usuario' => [
                        'id' => $usuario->getId(),
                        'nome' => $usuario->getNome(),
                        'email' => $usuario->getEmail(),
                    ],
                    'credencial' => [
                        'id' => $credencial->getId(),
                        'nome_usuario' => $credencial->getNomeUsuario(),
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao registrar usuário.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Realiza o login do usuário.
     * Gera um token de autenticação que expira em 1 hora.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validação dos dados de entrada
        $validador = Validator::make($request->all(), [
            'nome_usuario' => 'required|string',
            'senha' => 'required|string',
        ], [
            'nome_usuario.required' => 'O nome de usuário é obrigatório.',
            'senha.required' => 'A senha é obrigatória.',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação.',
                'errors' => $validador->errors()
            ], 422);
        }

        try {
            // Busca a credencial pelo nome de usuário
            $credencial = Credencial::where('nome_usuario', $request->nome_usuario)->first();

            // Verifica se a credencial existe e a senha está correta
            if (!$credencial || !Hash::check($request->senha, $credencial->getSenha())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciais inválidas.',
                ], 401);
            }

            // Verifica se a conta está ativa
            if (!$credencial->isAtivo()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conta não ativada. Verifique seu e-mail.',
                ], 403);
            }

            // Gera o token de autenticação
            $token = $this->gerarToken($credencial);

            // Armazena o token e a data de expiração
            $expiraEm = now()->addHour(); // Token expira em 1 hora
            $credencial->api_token = $token;
            $credencial->token_expira_em = $expiraEm;
            $credencial->save();

            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso.',
                'data' => [
                    'id' => $credencial->getId(),
                    'nome_usuario' => $credencial->getNomeUsuario(),
                    'tipo_perfil' => $credencial->getTipoPerfil()->value,
                    'token' => $token,
                    'tipo_token' => 'Bearer',
                    'expira_em' => $expiraEm->toDateTimeString(),
                    'expira_em_segundos' => 3600, // 1 hora em segundos
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao realizar login.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Realiza o logout do usuário.
     * Remove o token de autenticação.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $credencial = $request->user();

            if ($credencial) {
                // Remove o token
                $credencial->api_token = null;
                $credencial->token_expira_em = null;
                $credencial->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Logout realizado com sucesso.',
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado.',
            ], 401);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao realizar logout.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ativa a conta do usuário usando o código de ativação.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ativarConta(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'codigo' => 'required|string',
        ], [
            'codigo.required' => 'O código de ativação é obrigatório.',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação.',
                'errors' => $validador->errors()
            ], 422);
        }

        try {
            $credencial = Credencial::where('codigo', $request->codigo)->first();

            if (!$credencial) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código de ativação inválido.',
                ], 404);
            }

            if ($credencial->isAtivo()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta conta já está ativa.',
                ], 400);
            }

            $credencial->setAtivo(true);
            $credencial->save();

            return response()->json([
                'success' => true,
                'message' => 'Conta ativada com sucesso. Você já pode fazer login.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao ativar conta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Solicita recuperação de senha.
     * Gera um novo código de recuperação.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function solicitarRecuperacaoSenha(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'nome_usuario' => 'required|string',
        ], [
            'nome_usuario.required' => 'O nome de usuário é obrigatório.',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação.',
                'errors' => $validador->errors()
            ], 422);
        }

        try {
            $credencial = Credencial::where('nome_usuario', $request->nome_usuario)->first();

            if (!$credencial) {
                // Por segurança, não informar se o usuário existe ou não
                return response()->json([
                    'success' => true,
                    'message' => 'Se o usuário existir, um código de recuperação foi enviado.',
                ], 200);
            }

            // Gera novo código de recuperação
            $credencial->setCodigo((string) Str::uuid());
            $credencial->save();

            return response()->json([
                'success' => true,
                'message' => 'Código de recuperação gerado com sucesso.',
                'data' => [
                    'codigo_recuperacao' => $credencial->getCodigo(), // Enviar por e-mail
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao solicitar recuperação de senha.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Redefine a senha usando o código de recuperação.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function redefinirSenha(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'codigo' => 'required|string',
            'senha' => 'required|string|min:8|confirmed',
        ], [
            'codigo.required' => 'O código de recuperação é obrigatório.',
            'senha.required' => 'A nova senha é obrigatória.',
            'senha.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'senha.confirmed' => 'A confirmação de senha não corresponde.',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação.',
                'errors' => $validador->errors()
            ], 422);
        }

        try {
            $credencial = Credencial::where('codigo', $request->codigo)->first();

            if (!$credencial) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código de recuperação inválido.',
                ], 404);
            }

            // Atualiza a senha com criptografia
            $credencial->setSenha(Hash::make($request->senha));
            // Gera novo código para invalidar o atual
            $credencial->setCodigo((string) Str::uuid());
            // Remove tokens ativos
            $credencial->api_token = null;
            $credencial->token_expira_em = null;
            $credencial->save();

            return response()->json([
                'success' => true,
                'message' => 'Senha redefinida com sucesso. Faça login com sua nova senha.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao redefinir senha.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retorna os dados do usuário autenticado.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function perfil(Request $request)
    {
        try {
            $credencial = $request->user();

            if (!$credencial) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado.',
                ], 401);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $credencial->getId(),
                    'nome_usuario' => $credencial->getNomeUsuario(),
                    'tipo_perfil' => $credencial->getTipoPerfil()->value,
                    'ativo' => $credencial->isAtivo(),
                    'criacao' => $credencial->criacao?->toDateTimeString(),
                    'ultima_atualizacao' => $credencial->ultima_atualizacao?->toDateTimeString(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter perfil.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Renova o token de autenticação.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function renovarToken(Request $request)
    {
        try {
            $credencial = $request->user();

            if (!$credencial) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado.',
                ], 401);
            }

            // Gera novo token
            $token = $this->gerarToken($credencial);
            $expiraEm = now()->addHour(); // Token expira em 1 hora

            $credencial->api_token = $token;
            $credencial->token_expira_em = $expiraEm;
            $credencial->save();

            return response()->json([
                'success' => true,
                'message' => 'Token renovado com sucesso.',
                'data' => [
                    'token' => $token,
                    'tipo_token' => 'Bearer',
                    'expira_em' => $expiraEm->toDateTimeString(),
                    'expira_em_segundos' => 3600,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao renovar token.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gera um token único para o usuário.
     * 
     * @param Credencial $credencial
     * @return string
     */
    private function gerarToken(Credencial $credencial): string
    {
        return hash('sha256', Str::random(60) . $credencial->getId() . time());
    }
}
