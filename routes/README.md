# 🗺️ Camada de Rotas (Routes)

Esta pasta contém todos os arquivos de definição de rotas da aplicação. Pense nela como o **mapa** ou o "guia telefônico" da nossa API/Web App.

É aqui que conectamos uma URL e um Verbo HTTP (como `GET`, `POST`, `PUT`, `DELETE`) a um método específico em um `Controller`.

## ✅ Responsabilidade Principal

A única responsabilidade desta camada é **declarar** os "pontos de entrada" (endpoints) da aplicação. Um arquivo de rota deve ser uma lista clara e legível de:

-   A URI (ex: `/users/{id}`).
-   O Verbo HTTP (ex: `GET`).
-   O `Controller` e o `método` que irão lidar com a requisição (ex: `[UserController::class, 'show']`).
-   Quais `Middlewares` (filtros) devem ser aplicados àquela rota (ex: `middleware('auth:api')`).

## ⛔ A REGRA DE OURO: Rotas são "burras" e declarativas

Para manter nossa arquitetura limpa e testável, esta camada **NUNCA** deve conter lógica.

-   **NÃO USE CLOSURES (FUNÇÕES ANÔNIMAS):**

    -   **Ruim (NÃO FAÇA):**
        ```php
        Route::post('/users', function (Request $request) {
            // Lógica de validação e criação...
            $data = $request->validate([...]);
            $user = User::create($data);
            return $user;
        });
        ```
    -   **Por quê?** Isso coloca lógica de negócio e de controle diretamente no arquivo de rotas. Quebra toda a nossa arquitetura de `Services`, `Repositories` e `Controllers`.
    -   **Bom (FAÇA ISSO):**
        ```php
        use App\Http\Controllers\UserController;
        Route::post('/users', [UserController::class, 'store']);
        ```

-   **NÃO FAÇA QUERIES NO BANCO:** Nunca use `User::find()` ou `DB::table()` aqui.
-   **NÃO RETORNE RESPOSTAS DIRETAS:** A rota não deve retornar `response()->json(...)`. Isso é trabalho do `Controller`.

**Pense neste arquivo como um "menu de restaurante": ele lista os pratos e preços (`rotas`), mas não cozinha a comida (`lógica`).**

---

### Os Diferentes Arquivos de Rota

O Laravel divide as rotas em arquivos para diferentes propósitos:

-   `routes/api.php`: **(O MAIS IMPORTANTE PARA NÓS)**

    -   **Propósito:** Para nossa API **stateless** (sem estado).
    -   **Middleware Automático:** Todas as rotas aqui passam pelo grupo `api` (que inclui, por exemplo, `throttle:api` para rate limiting).
    -   **Prefixo Automático:** Todas as rotas aqui ganham o prefixo `/api` (ex: `/users` aqui vira `/api/users`).

-   `routes/web.php`:

    -   **Propósito:** Para páginas web tradicionais, **stateful** (com estado).
    -   **Middleware Automático:** Passam pelo grupo `web` (que inclui sessões, cookies, e proteção CSRF). Use isso se você tiver páginas Blade renderizadas pelo servidor.

-   `routes/console.php`:

    -   **Propósito:** Para registrar comandos de console (`php artisan seu-comando`).

-   `routes/channels.php`:
    -   **Propósito:** Para registrar canais de broadcasting (WebSockets) para eventos em tempo real.

---

### 💡 Melhores Práticas

1.  **Agrupamento (Grouping):** Mantenha seu código limpo agrupando rotas que compartilham um prefixo, middleware ou controller.

    ```php
    /*use App\Http\Controllers\PostController;

    // Agrupadas pelo middleware 'auth:api'
    Route::middleware('auth:api')->group(function () {

        // Agrupadas pelo prefixo 'posts'
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index']);
            Route::post('/', [PostController::class, 'store']);
            Route::get('/{post}', [PostController::class, 'show']);
            Route::put('/{post}', [PostController::class, 'update']);
            Route::delete('/{post}', [PostController::class, 'destroy']);
        });

        // ...outras rotas autenticadas...
    });
    ```

2.  **Rotas de Recurso (Resourceful Routes):** Para CRUDs padrão, use `Route::resource` para gerar as 7 rotas padrão de uma vez.

    ```php
    //use App\Http\Controllers\PostController;

    // Isto cria 7 rotas (index, create, store, show, edit, update, destroy)
    // Use ->apiResource() se for uma API (sem as rotas 'create' e 'edit' de HTML)
    //Route::apiResource('posts', PostController::class);
    ```

3.  **Route-Model Binding:**
    Sempre que possível, use o "binding" automático do Laravel. Note que na rota usamos `{post}` (nome do parâmetro) e no método do Controller, recebemos `Post $post` (o modelo).

    -   **Rota (`routes/api.php`):**
        `Route::get('/posts/{post}', [PostController::class, 'show']);`

    -   **Controller (`PostController.php`):**
        ```php
        // O Laravel automaticamente faz o "find($id)" para você.
        // Se não encontrar, ele retorna um 404 automaticamente.
        /*public function show(Post $post)
        {
            // O $post já é o objeto pronto para usar!
            return response()->json($post);
        }
        ```
