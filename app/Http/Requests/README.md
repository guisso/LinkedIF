# 📁 Camada de Requisições (Form Requests)

Esta camada é responsável por uma tarefa crucial: **validar os dados de entrada** das requisições HTTP.

No Laravel, esta camada é implementada através de classes que estendem `Illuminate\Foundation\Http\FormRequest`.

## ✅ Responsabilidade Principal

A única responsabilidade de uma classe de Request é:

1.  **Definir as regras de autorização:** O usuário logado _pode_ tentar fazer esta ação?
2.  **Definir as regras de validação:** Os dados enviados (JSON, formulário) estão corretos e completos?
3.  **Definir mensagens de erro customizadas** (opcional).

O maior benefício é **remover a lógica de validação de dentro dos Controllers**, mantendo-os "magros" (Skinny Controllers).

## 🪄 Como Funciona (A Mágica do Laravel)

Quando você usa a "injeção de dependência" para "tipar" um Form Request no método de um Controller, o Laravel faz o seguinte **automaticamente** _antes_ de executar qualquer código seu no Controller:

1.  Cria uma instância da sua classe de Request (ex: `StoreUserRequest`).
2.  Executa o método `authorize()`.
    -   Se `authorize()` retornar `false`, o Laravel **barra a requisição** e retorna um erro 403 (Forbidden) automaticamente.
3.  Se `authorize()` retornar `true`, o Laravel executa o método `rules()`.
    -   Ele aplica as regras de validação aos dados da requisição.
    -   Se a validação falhar, o Laravel **barra a requisição** e retorna um erro 422 (Unprocessable Entity) com a lista de erros em JSON, automaticamente.
4.  Se a validação passar, o Laravel **continua a execução** e finalmente chama o seu método no Controller.

O seu Controller só é executado se a autorização E a validação passarem.

## ⛔ O que NUNCA fazer em um Form Request

-   **Executar lógica de negócio:** Nunca tente criar um usuário, calcular um valor ou chamar um Serviço de dentro de um Form Request. Esta classe serve apenas para **validar**.
-   **Acessar o banco de dados (com exceções):** Você _pode_ consultar o banco no método `authorize()` (ex: verificar se o usuário é dono do post que quer editar). No método `rules()`, evite consultas, a menos que seja para uma regra de validação específica (como a regra `Rule::unique`).

---

### 📝 Exemplo de um Bom Form Request

```php
/*<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool

    public function authorize(): bool
    {
        // Exemplo: O usuário só pode atualizar um post se for o dono dele.
        // Vamos assumir que o ID do post está vindo da rota.
        $post = $this->route('post');

        return Auth::user()->id === $post->user_id;
    }

    /**
     * Define as regras de validação que se aplicam à requisição.
     *
     * @return array

    public function rules(): array
    {
        // Pega o ID do post da rota para a regra "unique"
        $postId = $this->route('post')->id;

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                // Garante que o título seja único, ignorando o post atual
                Rule::unique('posts')->ignore($postId),
            ],
            'body' => 'required|string|min:50',
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }

    /**
     * Mensagens customizadas para erros de validação (Opcional).
     *
     * @return array

    public function messages(): array
    {
        return [
            'title.required' => 'O campo título é obrigatório.',
            'title.unique' => 'Este título já está em uso por outro post.',
            'body.min' => 'O corpo do post precisa ter pelo menos 50 caracteres.',
        ];
    }
}
```
