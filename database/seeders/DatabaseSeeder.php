<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Popula tipos de oportunidade e oportunidades de exemplo
        $this->call([
            TipoOportunidadeSeeder::class,
            OportunidadeSeeder::class,
            CandidatoCompletoSeeder::class,
        ]);
    }
}
