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
        Schema::create('editores', function (Blueprint $table) {
            // A chave primária é a FK do usuário (Herança)
            $table->foreignId('usuario_id')->primary()->constrained('usuarios')->onDelete('cascade');

            // CAMPOS QUE FALTAVAM:
            $table->string('cnpj', 18)->unique()->nullable(); // <--- Adicione isso
            $table->string('descricao', 500)->nullable();     // <--- Adicione isso

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editores');
    }
};
