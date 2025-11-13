<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidato_id')
                ->constrained('candidatos')
                ->onDelete('cascade');

            $table->string('nome', 20); // O diagrama especifica 20
            $table->smallInteger('ingresso'); // 'Short' -> 'smallInteger'
            $table->smallInteger('conclusao')->nullable();
            $table->string('instituicao', 20); // O diagrama especifica 20
            $table->string('sitio')->nullable(); // 'URL' -> 'string'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};