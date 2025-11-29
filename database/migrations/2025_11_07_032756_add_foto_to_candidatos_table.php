<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // "up" = O que fazer (Adicionar a coluna)
        Schema::table('candidatos', function (Blueprint $table) {

            // Adiciona a coluna 'foto'
            // ->nullable() permite que ela seja nula (sem foto)
            // ->after('id') (opcional) coloca ela logo depois da coluna 'id'
            $table->string('foto')->nullable()->after('id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // "down" = O que fazer se dermos "rollback" (Remover a coluna)
        Schema::table('candidatos', function (Blueprint $table) {

            $table->dropColumn('foto');

        });
    }
};