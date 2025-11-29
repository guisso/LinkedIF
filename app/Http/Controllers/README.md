# 📍 Camada de Controladores (Controllers)

Esta camada é a **porta de entrada** para as requisições HTTP da nossa aplicação. Ela atua como um "maestro" ou "controlador de tráfego".

## ✅ Responsabilidade Principal

A única responsabilidade de um Controller é **orquestrar** o fluxo da requisição. Ele deve:

1.  Receber a `Request` (requisição HTTP).
2.  Validar os dados de entrada (preferencialmente usando **Form Requests**).
3.  Delegar a lógica de negócio para a **Camada de Serviço (Service)** apropriada.
4.  Receber o resultado do Serviço.
5.  Formatar e retornar a `Response` (resposta), geralmente em formato JSON para a API.

## ⛔ O que NUNCA fazer em um Controller

Para manter nosso código limpo e organizado, Controllers **NÃO DEVEM**:

-   **Conter Lógica de Negócio:** (Ex: calcular um desconto, verificar se um usuário tem permissão para uma ação complexa, etc.). Isso é responsabilidade dos **Services**.
-   **Acessar o Banco de Dados Diretamente:** (Ex: `User::find($id)`, `DB::table('...')`, etc.). Isso é responsabilidade dos **Repositories**.
-   **Manipular Dados:** (Ex: formatar um array, combinar dados de diferentes fontes). Apenas passe os dados validados para o Serviço e deixe ele trabalhar.

**Lembre-se: Controllers devem ser "magros" (Skinny Controllers).**

---

### 📝 Exemplo de um Bom Controller

Veja como um método `store` deve se parecer, usando Injeção de Dependência e um Form Request:

```php
/*<?php

namespace App\Http\Controllers;

// 1. O Form Request para validação
use App\Http\Requests\StoreUserRequest;

// 2. O Service para a lógica de negócio
use App\Services\UserService;

use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

     * Injetamos o Service no construtor
     * para que o Laravel o resolva automaticamente.

    public function __construct(protected UserService $userService)
    {
    }


     * Método para criar um novo usuário.

    public function store(StoreUserRequest $request): JsonResponse
    {
        // 1. A validação já foi feita automaticamente pelo StoreUserRequest.
        // Pegamos apenas os dados validados.
        $validatedData = $request->validated();

        // 2. Delegamos a criação para o Service.
        // O Controller não sabe "como" o usuário é criado.
        $user = $this->userService->createUser($validatedData);

        // 3. Retornamos a resposta JSON.
        return response()->json($user, 201);
    }
}*/
```
