<?php

namespace App\Mail;

use App\Models\Usuario; // Certifique-se que o caminho está correto
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarVerificacaoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $codigoAtivacao;

    /**
     * Crie uma nova instância da mensagem.
     */
    public function __construct(Usuario $usuario, string $codigoAtivacao)
    {
        $this->usuario = $usuario;
        $this->codigoAtivacao = $codigoAtivacao;
    }

    /**
     * Obtenha o envelope da mensagem.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ative sua Conta no LinkedIF',
        );
    }

    /**
     * Obtenha a definição de conteúdo da mensagem.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verificacao', // Usaremos esta view
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}