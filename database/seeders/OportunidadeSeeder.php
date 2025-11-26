<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Oportunidade;
use App\Models\Editor;
use App\Models\TipoOportunidade;
use App\Models\Enums\Modalidade;
use Carbon\Carbon;

/**
 * Seeder para popular oportunidades de exemplo.
 */
class OportunidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Busca o primeiro editor (usuário que você criou)
        $editor = Editor::first();

        if (!$editor) {
            $this->command->error('Nenhum editor encontrado! Crie um usuário Professor ou Empresa primeiro.');
            return;
        }

        // Busca tipos de oportunidade
        $tipoEstagio = TipoOportunidade::where('nome', 'Estágio')->first();
        $tipoEmprego = TipoOportunidade::where('nome', 'Emprego')->first();
        $tipoPesquisa = TipoOportunidade::where('nome', 'Pesquisa')->first();
        $tipoBolsa = TipoOportunidade::where('nome', 'Bolsa')->first();

        $oportunidades = [
            [
                'editor_id' => $editor->usuario_id,
                'tipo_oportunidade_id' => $tipoEstagio?->id ?? 1,
                'codigo' => 'OPT-' . date('Ymd') . '-EST1',
                'titulo' => 'Estágio em Desenvolvimento Full Stack',
                'descricao' => 'Oportunidade para estudantes desenvolverem aplicações web completas utilizando tecnologias modernas como React, Node.js e PostgreSQL.',
                'requisitos' => 'Cursando Ciência da Computação ou áreas afins. Conhecimento básico em JavaScript, HTML e CSS. Vontade de aprender e trabalhar em equipe.',
                'beneficios' => 'Vale-transporte, vale-refeição, ambiente de trabalho moderno, mentoria técnica, possibilidade de efetivação.',
                'remuneracao' => 1200.00,
                'vagas' => 3,
                'inicio' => Carbon::now()->addDays(15),
                'termino' => Carbon::now()->addMonths(6),
                'horarioInicio' => Carbon::createFromTime(14, 0),
                'horarioTermino' => Carbon::createFromTime(18, 0),
                'escala' => 20,
                'modalidade' => Modalidade::HIBRIDO->value,
                'localidade' => 'Montes Claros - MG',
            ],
            [
                'editor_id' => $editor->usuario_id,
                'tipo_oportunidade_id' => $tipoPesquisa?->id ?? 3,
                'codigo' => 'OPT-' . date('Ymd') . '-PES1',
                'titulo' => 'Bolsista de Iniciação Científica em IA',
                'descricao' => 'Projeto de pesquisa focado em Machine Learning aplicado à análise de dados educacionais. Você trabalhará com algoritmos de classificação e regressão.',
                'requisitos' => 'Conhecimento em Python. Noções de estatística. Interesse em Inteligência Artificial. Cursando a partir do 3º período.',
                'beneficios' => 'Bolsa CNPQ, certificado, publicação em eventos científicos, experiência em pesquisa.',
                'remuneracao' => 400.00,
                'vagas' => 2,
                'inicio' => Carbon::now()->addDays(30),
                'termino' => Carbon::now()->addYear(),
                'horarioInicio' => null,
                'horarioTermino' => null,
                'escala' => 12,
                'modalidade' => Modalidade::PRESENCIAL->value,
                'localidade' => 'IFNMG - Campus Montes Claros',
            ],
            [
                'editor_id' => $editor->usuario_id,
                'tipo_oportunidade_id' => $tipoEmprego?->id ?? 2,
                'codigo' => 'OPT-' . date('Ymd') . '-EMP1',
                'titulo' => 'Desenvolvedor Mobile Júnior',
                'descricao' => 'Vaga para desenvolvedor mobile com foco em aplicativos híbridos usando React Native. Trabalhará em projetos inovadores para clientes nacionais.',
                'requisitos' => 'Experiência com React Native ou Flutter. Conhecimento em consumo de APIs REST. Familiaridade com Git. Proatividade e trabalho em equipe.',
                'beneficios' => 'Plano de saúde, vale-alimentação, home office flexível, PLR anual, ambiente descontraído.',
                'remuneracao' => 3500.00,
                'vagas' => 1,
                'inicio' => Carbon::now()->addDays(20),
                'termino' => null,
                'horarioInicio' => Carbon::createFromTime(8, 0),
                'horarioTermino' => Carbon::createFromTime(17, 0),
                'escala' => 40,
                'modalidade' => Modalidade::REMOTO->value,
                'localidade' => null,
            ],
            [
                'editor_id' => $editor->usuario_id,
                'tipo_oportunidade_id' => $tipoEstagio?->id ?? 1,
                'codigo' => 'OPT-' . date('Ymd') . '-EST2',
                'titulo' => 'Estágio em Suporte Técnico',
                'descricao' => 'Oportunidade para atuar no suporte técnico de sistemas, auxiliando usuários e resolvendo problemas de TI.',
                'requisitos' => 'Cursando Redes de Computadores, Sistemas de Informação ou áreas correlatas. Boa comunicação. Facilidade com resolução de problemas.',
                'beneficios' => 'Vale-transporte, seguro de vida, treinamentos, ambiente acolhedor.',
                'remuneracao' => 800.00,
                'vagas' => 2,
                'inicio' => Carbon::now()->addDays(10),
                'termino' => Carbon::now()->addMonths(6),
                'horarioInicio' => Carbon::createFromTime(8, 0),
                'horarioTermino' => Carbon::createFromTime(14, 0),
                'escala' => 30,
                'modalidade' => Modalidade::PRESENCIAL->value,
                'localidade' => 'Montes Claros - MG',
            ],
            [
                'editor_id' => $editor->usuario_id,
                'tipo_oportunidade_id' => $tipoBolsa?->id ?? 5,
                'codigo' => 'OPT-' . date('Ymd') . '-BOL1',
                'titulo' => 'Monitoria de Programação I',
                'descricao' => 'Vaga de monitoria para auxiliar alunos iniciantes em programação. Você ajudará em exercícios, tirará dúvidas e acompanhará o desenvolvimento dos estudantes.',
                'requisitos' => 'Ter cursado Programação I com aprovação. Disponibilidade de 8 horas semanais. Paciência e didática.',
                'beneficios' => 'Bolsa institucional, certificado, experiência docente, desenvolvimento de habilidades de ensino.',
                'remuneracao' => 400.00,
                'vagas' => 1,
                'inicio' => Carbon::now()->addDays(7),
                'termino' => Carbon::now()->addMonths(4),
                'horarioInicio' => null,
                'horarioTermino' => null,
                'escala' => 8,
                'modalidade' => Modalidade::PRESENCIAL->value,
                'localidade' => 'IFNMG - Campus Montes Claros',
            ],
        ];

        foreach ($oportunidades as $oportunidadeData) {
            Oportunidade::create($oportunidadeData);
        }

        $this->command->info('5 oportunidades de exemplo criadas com sucesso!');
    }
}

