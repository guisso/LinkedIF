<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Credencial;
use App\Models\Candidato;
use App\Models\Competencia;
use App\Models\Curso;
use App\Models\Experiencia;
use App\Models\Enums\TipoPerfil;
use Illuminate\Support\Facades\Hash;

class CandidatoCompletoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa dados existentes do usuário teste_completo
        $usuarioExistente = Usuario::where('email', 'teste_completo@linkedif.com')->first();
        if ($usuarioExistente) {
            // Deleta credencial (cascade vai deletar candidato e relacionamentos)
            Credencial::where('usuario_id', $usuarioExistente->id)->delete();
            $usuarioExistente->delete();
            $this->command->info('🗑️  Usuário teste_completo anterior removido.');
        }

        // 1. Criar o Usuário
        $usuario = Usuario::create([
            'nome' => 'Candidato Teste Completo',
            'email' => 'teste_completo@linkedif.com',
            'telefone' => '38999887766',
            'whatsApp' => true,
            'nascimento' => '2000-05-15',
            'idade' => 24,
        ]);

        // 2. Criar a Credencial
        Credencial::create([
            'usuario_id' => $usuario->id,
            'nome_usuario' => 'teste_completo',
            'senha' => Hash::make('12345678'),
            'ativo' => true,
            'tipo_perfil' => TipoPerfil::CANDIDATO,
        ]);

        // 3. Criar o Candidato (SEM foto para ficar 80% completo - faltando apenas foto)
        $candidato = Candidato::create([
            'usuario_id' => $usuario->id,
            'curso' => 'Técnico em Informática',
            'foto' => null, // Faltando foto = 80% de completude
        ]);

        // 4. Criar Competências
        $competencias = [
            'Trabalho em equipe',
            'Comunicação efetiva',
            'Resolução de problemas',
            'Pensamento crítico',
            'Gestão de tempo',
        ];

        foreach ($competencias as $descricao) {
            Competencia::create([
                'candidato_id' => $candidato->usuario_id,
                'descricao' => $descricao,
            ]);
        }

        // 5. Criar Cursos/Formação Acadêmica
        Curso::create([
            'candidato_id' => $candidato->usuario_id,
            'nome' => 'Técnico Informática',
            'instituicao' => 'IFNMG Montes Claros',
            'ingresso' => 2020,
            'conclusao' => 2023,
            'sitio' => 'https://www.ifnmg.edu.br',
        ]);

        Curso::create([
            'candidato_id' => $candidato->usuario_id,
            'nome' => 'JavaScript Moderno',
            'instituicao' => 'Udemy',
            'ingresso' => 2023,
            'conclusao' => 2023,
            'sitio' => 'https://www.udemy.com',
        ]);

        // 6. Criar Experiências Profissionais
        Experiencia::create([
            'candidato_id' => $candidato->usuario_id,
            'funcao' => 'Estagiário de Desenvolvimento',
            'instituicao' => 'TechSolutions Ltda',
            'inicio' => '2022-08-01',
            'termino' => '2023-12-20',
            'descricao' => 'Desenvolvimento de aplicações web utilizando Laravel e Vue.js. Participação em reuniões de planejamento e revisão de código.',
        ]);

        Experiencia::create([
            'candidato_id' => $candidato->usuario_id,
            'funcao' => 'Desenvolvedor Junior',
            'instituicao' => 'CodeMasters',
            'inicio' => '2024-01-15',
            'termino' => null,
            'descricao' => 'Desenvolvimento full-stack com foco em APIs RESTful e interfaces responsivas. Trabalho com metodologias ágeis (Scrum).',
        ]);

        Experiencia::create([
            'candidato_id' => $candidato->usuario_id,
            'funcao' => 'Monitor de Programação',
            'instituicao' => 'IFNMG Montes Claros',
            'inicio' => '2021-03-01',
            'termino' => '2022-06-30',
            'descricao' => 'Auxílio aos alunos nas disciplinas de programação, elaboração de materiais didáticos e ministração de aulas de reforço.',
        ]);

        $this->command->info('✅ Usuário teste_completo criado com sucesso!');
        $this->command->info('📧 Email: teste_completo@linkedif.com');
        $this->command->info('👤 Login: teste_completo');
        $this->command->info('🔑 Senha: 12345678');
        $this->command->info('📊 Completude: 80% (faltando apenas a foto)');
    }
}
