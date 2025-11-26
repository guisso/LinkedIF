<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TipoOportunidade;

/**
 * Seeder para popular a tabela tipo_oportunidades com tipos padrão.
 */
class TipoOportunidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nome' => 'Estágio'],
            ['nome' => 'Emprego'],
            ['nome' => 'Pesquisa'],
            ['nome' => 'Extensão'],
            ['nome' => 'Bolsa'],
            ['nome' => 'Monitoria'],
            ['nome' => 'Projeto'],
            ['nome' => 'Voluntariado'],
        ];

        foreach ($tipos as $tipo) {
            TipoOportunidade::firstOrCreate(
                ['nome' => $tipo['nome']], // Verifica se já existe
                $tipo // Cria se não existir
            );
        }

        $this->command->info('Tipos de oportunidade criados com sucesso!');
    }
}

