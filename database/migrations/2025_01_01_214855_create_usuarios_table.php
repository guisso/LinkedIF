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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // id: Long (BigInt)
            $table->string('nome', 45);
            $table->string('email', 250)->unique();
            $table->string('telefone', 16);
            $table->boolean('whatsApp')->default(false);
            $table->date('nascimento');
            $table->tinyInteger('idade'); // idade: byte
            
            // Isto vai usar os nomes 'criacao' e 'ultimaAtualizacao'
            // que definimos na classe Entidade.php
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
