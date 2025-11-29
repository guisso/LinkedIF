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

// <-- MUDANÇA 1: Importar classes de E-mail
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarVerificacaoEmail;

/**
 * Controller responsável pela autenticação de usuários.
 * Gerencia registro, login, logout e operações relacionadas a tokens.
 */
class AuthController extends Controller
{
    /**
     * Registra um novo usuário no sistema.
     * * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Registra um novo usuário no sistema (CU01).
     * Agora suporta perfis de Aluno, Professor e Empresa.
     */
    public function registro(Request $request)
    {
        // 1. Validação Expandida (Condicional)
        $validador = Validator::make($request->all(), [
            // --- Dados Comuns ---
            'nome' => 'required|string|max:45',
            'email' => 'required|email|max:250|unique:usuarios,email',
            'telefone' => 'required|string|max:16',
            'nascimento' => 'required|date',
            'nome_usuario' => 'required|string|max:20|unique:credenciais,nome_usuario',
            'senha' => 'required|string|min:6',

            // --- Novo Campo: Tipo de Perfil ---
            'tipo_perfil' => 'required|string|in:ALUNO,PROFESSOR,EMPRESA',

            // --- Campos Condicionais ---
            // 'curso' é obrigatório APENAS se tipo_perfil for ALUNO
            'curso' => 'required_if:tipo_perfil,ALUNO|string|nullable|max:100',

            // 'cnpj' é obrigatório APENAS se tipo_perfil for EMPRESA
            'cnpj' => 'required_if:tipo_perfil,EMPRESA|string|nullable|size:14|unique:editores,cnpj',

            // 'descricao' é opcional para empresas
            'descricao' => 'nullable|string|max:500',

        ], [
            // Mensagens personalizadas
            'tipo_perfil.required' => 'Selecione o tipo de perfil (Aluno, Professor ou Empresa).',
            'tipo_perfil.in' => 'Tipo de perfil inválido.',
            'curso.required_if' => 'O curso é obrigatório para alunos.',
            'cnpj.required_if' => 'O CNPJ é obrigatório para empresas.',
            'cnpj.size' => 'O CNPJ deve ter 14 dígitos.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            // ... suas outras mensagens ...
        ]);

        if ($validador->fails()) {
            return response()->json(['success' => false, 'errors' => $validador->errors()], 422);
        }

        DB::beginTransaction();
        try {
            // 2. Cria o Usuário (Pai)
            $nascimento = new \DateTime($request->nascimento);
            $idade = (new \DateTime())->diff($nascimento)->y;

            $usuario = new Usuario();
            $usuario->setNome($request->nome);
            $usuario->setEmail($request->email);
            $usuario->setTelefone($request->telefone);
            $usuario->setWhatsApp($request->whatsapp ?? false);
            $usuario->setNascimento(\Carbon\Carbon::parse($request->nascimento));
            $usuario->setIdade($idade);
            $usuario->save();

            // 3. Lógica de Perfil Específico (Filho)
            $tipoPerfilReq = $request->input('tipo_perfil');
            $tipoPerfilEnum = null;
            $ativo = false; // Padrão: inativo até validar e-mail (ou admin liberar)

            // --- SE FOR ALUNO (CANDIDATO) ---
            if ($tipoPerfilReq == 'ALUNO') {
                $tipoPerfilEnum = TipoPerfil::CANDIDATO;
                $ativo = true;

                // Cria o Candidato vinculado ao Usuario
                $candidato = new \App\Models\Candidato();
                $candidato->usuario_id = $usuario->getId(); // Herança (FK)
                $candidato->curso = $request->input('curso'); // Salva o curso
                // Adicione outros campos de candidato aqui se tiver
                $candidato->save();

                // --- SE FOR EMPRESA OU PROFESSOR (EDITOR) ---
            } else if ($tipoPerfilReq == 'EMPRESA' || $tipoPerfilReq == 'PROFESSOR') {
                $tipoPerfilEnum = ($tipoPerfilReq == 'EMPRESA') ? TipoPerfil::EMPRESA : TipoPerfil::PROFESSOR;
                $ativo = true; // Empresa precisa de aprovação (Fluxo Alternativo 4a)

                // Cria o Editor vinculado ao Usuario
                $editor = new \App\Models\Editor();
                $editor->usuario_id = $usuario->getId(); // Herança (FK)

                if ($tipoPerfilReq == 'EMPRESA') {
                    $editor->cnpj = $request->input('cnpj');
                    $editor->descricao = $request->input('descricao');
                }
                $editor->save();
            }

            // 4. Cria a Credencial
            $codigoAtivacao = (string) Str::uuid();

            $credencial = new Credencial();
            $credencial->usuario_id = $usuario->getId();
            $credencial->setNomeUsuario($request->nome_usuario);
            $credencial->setSenha(Hash::make($request->senha));
            $credencial->setTipoPerfil($tipoPerfilEnum);
            $credencial->setAtivo($ativo);
            $credencial->setCodigo($codigoAtivacao);
            $credencial->save();

            // 5. Envia E-mail
            //Mail::to($usuario->getEmail())->send(new EnviarVerificacaoEmail($usuario, $codigoAtivacao));

            DB::commit();

            // Mensagem personalizada baseada no status
            $msg = $ativo
                ? 'Cadastro realizado! Você já pode fazer login.'
                : 'Cadastro realizado! Sua conta de empresa passará por análise.';

            return response()->json([
                'success' => true,
                'message' => $msg,
                'data' => [
                    'id' => $usuario->getId(),
                    'tipo' => $tipoPerfilReq
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Erro ao registrar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Realiza o login do usuário.
     * (Seu código original, que já está correto)
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
     * (Seu código original, que já está correto)
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
     * (Seu código original, que já está correto)
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
     * (Seu código original, que já está correto)
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
     * (Seu código original, que já está correto)
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
     * (Seu código original, que já está correto)
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
                    'criacao' => $credencial->created_at?->toDateTimeString(),
                    'ultima_atualizacao' => $credencial->updated_at?->toDateTimeString(),
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
     * (Seu código original, que já está correto)
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
     * (Seu código original, que já está correto)
     */
    private function gerarToken(Credencial $credencial): string
    {
        return hash('sha256', Str::random(60) . $credencial->getId() . time());
    }
}