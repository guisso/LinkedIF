<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Classe Model abstrata que serve como base para todas as outras entidades.
 *
 * Esta classe NÃO deve ser instanciada diretamente.
 *
 * Ela define os nomes das colunas de timestamp personalizados
 * (criacao, ultimaAtualizacao) conforme o diagrama de entidades,
 * fazendo o "de-para" com o padrão do Laravel (created_at, updated_at).
 */
abstract class Entidade extends Model
{
    /**
     * Define o nome da coluna "created at" para 'criacao'.
     *
     * @var string
     */
    const CREATED_AT = 'criacao';

    /**
     * Define o nome da coluna "updated at" para 'ultimaAtualizacao'.
     *
     * @var string
     */
    const UPDATED_AT = 'ultimaAtualizacao';
}