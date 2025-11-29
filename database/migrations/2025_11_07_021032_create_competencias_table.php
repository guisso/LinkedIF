<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('competencias', function (Blueprint $table) {
            $table->id();

            // CORREÇÃO: Aponta para 'usuario_id' na tabela 'candidatos'
            $table->foreignId('candidato_id')
                ->constrained('candidatos', 'usuario_id') // <--- Mudança aqui
                ->onDelete('cascade');

            $table->string('descricao', 150);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competencias');
    }
};