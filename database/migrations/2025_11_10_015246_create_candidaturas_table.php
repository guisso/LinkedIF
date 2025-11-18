<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidato_id')
                  ->constrained('candidatos')
                  ->onDelete('cascade');

            $table->foreignId('oportunidade_id')
                  ->constrained('oportunidades')
                  ->onDelete('cascade');

            $table->string('mensagem', 250)->nullable();

            // Melhor prática: valor fixo na migration + cast no model
            $table->tinyInteger('estado')
                  ->default(1)
                  ->comment('0=Lida, 1=Em análise, 2=Aprovada, 3=Rejeitada, 4=Desistência');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidaturas');
    }
};