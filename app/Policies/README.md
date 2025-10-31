# 🔐 Camada de Autorização (Policies)

Esta camada é responsável por toda a **lógica de autorização** da nossa aplicação. As classes "Policy" centralizam as regras que determinam se um usuário autenticado tem permissão para executar uma ação específica em um determinado recurso (Model).

Elas respondem a perguntas como:

-   "O usuário A pode _atualizar_ o Post B?"
-   "O usuário A pode _criar_ um novo Post?"
-   "O usuário A pode _ver_ o Post B?"

## ✅ Responsabilidade Principal

A responsabilidade de uma Policy é conter métodos que retornam `true` ou `false` (ou uma `Response` de negação) para cada ação de CRUD (e ações customizadas) em um Model.

O objetivo é remover completamente verificações de permissão de dentro dos `Controllers` e `Services`. Em vez de um Controller verificar `if (Auth::user()->id === $post->user_id)`, ele simplesmente "pergunta" à Policy se a ação é permitida.

## ⚖️ Policy vs. Middleware: Qual a diferença?

Esta é uma distinção crucial para a arquitetura:

-   **Middleware (O Porteiro):** Verifica a **Rota/Requisição**. Ele responde a perguntas amplas, _antes_ de chegar no Controller.

    -   Ex: "O usuário está logado?" (`auth`)
    -   Ex: "O usuário é um Administrador?" (`middleware('role:admin')`)
    -   Ele filtra o _acesso à rota_.

-   **Policy (O Guarda-costas do Dado):** Verifica a **Ação/Modelo**. Ele responde a perguntas granulares, _dentro_ do Controller, quando você já tem o dado (ou a intenção de criar um).
    -   Ex: "Este usuário é o _dono_ deste `$post` específico?" (`authorize('update', $post)`)
    -   Ex: "Este usuário pode criar um post _nesta categoria_?"
    -   Ele protege o _modelo_ e a _ação_.

## ⛔ O que NUNCA fazer em uma Policy

-   **NÃO executar lógica de negócio:** Uma Policy NUNCA deve alterar dados, chamar um Serviço ou disparar um evento. Ela apenas retorna `true` ou `false`.
-   **NÃO modificar o recurso:** Nunca salve o modelo (`$post->save()`) dentro de uma Policy.
-   **NÃO retornar dados:** Ela deve retornar um booleano (`bool`) ou um `Illuminate\Auth\Access\Response`.

---

### 📝 Exemplo de uma Boa Policy

```php
/*<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Permite que administradores façam qualquer ação.
     * Este método é verificado antes de todos os outros.

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null; // Continua para a verificação específica da ação
    }

    /**
     * Determina se o usuário pode ver a lista de posts.

    public function viewAny(User $user): bool
    {
        return true; // Qualquer usuário logado pode ver a listagem
    }

    /**
     * Determina se o usuário pode ver um post específico.

    public function view(User $user, Post $post): bool
    {
        // Ex: O post é público OU o usuário é o dono
        return $post->is_public || $user->id === $post->user_id;
    }

    /**
     * Determina se o usuário pode criar posts.

    public function create(User $user): bool
    {
        // Ex: Apenas usuários com o papel 'editor' ou 'admin' podem criar
        return $user->hasRole('editor');
    }

    /**
     * Determina se o usuário pode atualizar um post.

    public function update(User $user, Post $post): Response|bool
    {
        // Ex: Apenas o dono do post pode atualizá-lo
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny('Você não é o proprietário deste post.');
    }

    /**
     * Determina se o usuário pode deletar um post.

    publicD function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
```
