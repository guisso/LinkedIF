<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidaturasTable extends Migration
{
    public function up()
    {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidato_id')->constrained('candidatos')->onDelete('cascade');
            $table->foreignId('oportunidade_id')->constrained('oportunidades')->onDelete('cascade');

            $table->string('mensagem', 250)->nullable();

            $table->foreignId('estado_id')->constrained('estados')->onDelete('restrict');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidaturas');
    }
}
