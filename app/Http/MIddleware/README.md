# 🛡️ Camada de Middleware

Esta camada atua como o sistema de "porteiros" ou "filtros" da nossa aplicação. Um Middleware intercepta **todas** as requisições HTTP _antes_ que elas cheguem aos nossos Controllers, e também _depois_ que os Controllers enviam uma resposta.

## ✅ Responsabilidade Principal

A responsabilidade de um Middleware é **filtrar, verificar ou modificar** requisições HTTP.

O trabalho principal de um Middleware é fazer uma verificação e então decidir se a requisição deve:

1.  **Continuar** para a próxima camada (eventualmente, o Controller).
2.  **Ser barrada** e retornar uma resposta de erro imediatamente (ex: erro 401, 403, 429).

## 💡 Casos de Uso Comuns

Use Middlewares para:

-   **Autenticação:** Verificar se o usuário está logado (`Authenticate.php`).
-   **Autorização:** Verificar se o usuário tem uma permissão específica (ex: `CheckRoleMiddleware`, `CheckPermissionMiddleware`).
-   **Limitação de Taxa (Rate Limiting):** Bloquear um IP que está fazendo requisições demais (`ThrottleRequests.php`).
-   **Validação de Cabeçalhos (Headers):** Garantir que a requisição tenha o `Accept: application/json` correto.
-   **Manutenção:** Colocar a API em modo de manutenção.
-   **Logs Específicos:** Registrar informações sobre todas as requisições que passam por um grupo de rotas.

## ⛔ O que NUNCA fazer em um Middleware

-   **Conter Lógica de Negócio:** Um Middleware verifica se a "porta pode ser aberta", mas ele não executa a "tarefa" que está lá dentro. Isso é trabalho para os **Services**.
-   **Acessar o Banco de Dados (com exceções):** Um Middleware _pode_ consultar o banco para verificar uma permissão ou buscar o usuário autenticado, mas ele **nunca** deve realizar operações de escrita (criar, atualizar, deletar).

**Lembre-se: Middlewares são "guardas", não "trabalhadores".**

---

### 📝 Exemplo de um Bom Middleware

Veja um exemplo de um Middleware customizado que verifica se o usuário autenticado tem a permissão de "admin".

```php
/*<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfAdmin
{

     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed

    public function handle(Request $request, Closure $next)
    {
        // 1. Verificamos a condição (se o usuário não é admin)
        if (! Auth::user() || ! Auth::user()->isAdmin()) {

            // 2. Barramos a requisição e retornamos um erro 403 (Forbidden)
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
        }

        // 3. A condição foi satisfeita (é admin).
        // Deixamos a requisição continuar para o Controller.
        return $next($request);
    }
}
```
