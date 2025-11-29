<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('oportunidades', function (Blueprint $table) {
            $table->id();
            
            // Chave estrangeira para Editor
            $table->foreignId('editor_id')
                ->constrained('editores', 'usuario_id')
                ->onDelete('cascade');
            
            // Chave estrangeira para TipoOportunidade
            $table->foreignId('tipo_oportunidade_id')
                ->constrained('tipo_oportunidades')
                ->onDelete('restrict');
            
            // Informações básicas
            $table->string('codigo', 20)->unique();
            $table->string('titulo', 120);
            $table->string('descricao', 500);
            $table->string('requisitos', 500);
            $table->string('beneficios', 500)->nullable();
            
            // Detalhes da vaga
            $table->decimal('remuneracao', 10, 2)->nullable();
            $table->integer('vagas')->default(1);
            
            // Período
            $table->date('inicio');
            $table->date('termino')->nullable();
            
            // Horário (null indica flexível)
            $table->time('horarioInicio')->nullable();
            $table->time('horarioTermino')->nullable();
            
            // Escala e modalidade
            $table->tinyInteger('escala')->nullable();
            $table->tinyInteger('modalidade'); // 1=Presencial, 2=Remoto, 3=Híbrido
            $table->string('localidade', 50)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oportunidades');
    }
};
