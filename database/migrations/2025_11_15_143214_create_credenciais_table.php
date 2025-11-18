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
            Schema::create('credenciais', function (Blueprint $table) {
                  $table->id();
                  $table->foreignId('usuario_id')
                        ->nullable()
                        ->constrained('usuarios')
                        ->onDelete('cascade')
                        ->comment('Chave estrangeira para o usuário dono da credencial');
                  $table->string('nome_usuario', 20)
                        ->unique()
                        ->comment('Nome de usuário único utilizado na autenticação');
                  $table->text('senha')
                        ->comment('Senha criptografada utilizando hash seguro');
                  $table->timestamp('ultimo_login')
                        ->nullable()
                        ->comment('Data e hora do último acesso do usuário');
                  $table->boolean('ativo')
                        ->default(false)
                        ->comment('Indica se a credencial está ativa');
                  $table->uuid('codigo')
                        ->nullable()
                        ->comment('Código UUID para ativação/recuperação de senha');
                  $table->string('tipo_perfil', 20)
                        ->comment('Tipo de perfil do usuário');
                  $table->string('api_token', 80)
                        ->nullable()
                        ->unique()
                        ->comment('Token de autenticação API');
                  $table->timestamp('token_expira_em')
                        ->nullable()
                        ->comment('Data de expiração do token');
                  $table->timestamps();

                  // Índices
                  $table->index('nome_usuario', 'idx_credencial_nome_usuario');
                  $table->index('usuario_id', 'idx_credencial_usuario_id');
            });
      }

      /**
       * Reverse the migrations.
       */
      public function down(): void
      {
            Schema::dropIfExists('credenciais');
      }
};