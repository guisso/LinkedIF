<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('experiencias', function (Blueprint $table) {
            $table->id();

            // Chave estrangeira para conectar ao candidato
            $table->foreignId('candidato_id')
                ->constrained('candidatos') // 'constrained' usa as convenções do Laravel
                ->onDelete('cascade'); // Se um candidato for apagado, suas experiências também serão.

            $table->string('instituicao', 100);
            $table->string('funcao', 100);
            $table->string('descricao', 500);
            $table->date('inicio');
            $table->date('termino')->nullable(); // 'nullable' para "Present"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiencias');
    }
};