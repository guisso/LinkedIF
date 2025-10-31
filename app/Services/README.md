# 🧠 Camada de Serviços (Services)

Esta é a **camada de lógica de negócio** da aplicação. O "cérebro" de todo o sistema.

Quase toda a lógica, regras, cálculos e orquestração de tarefas complexas devem residir aqui. Esta camada fica entre os `Controllers` (que recebem a requisição) e os `Repositories` (que acessam os dados).

## ✅ Responsabilidade Principal

A responsabilidade de um Serviço é executar uma **tarefa de negócio** específica. Um Serviço:

1.  Recebe dados simples (geralmente um array) vindos do `Controller`.
2.  Executa todas as regras de negócio necessárias para aquela tarefa.
3.  Coordena múltiplas operações, se necessário (ex: chamar dois Repositórios diferentes, disparar um Evento, enviar um e-mail).
4.  Utiliza a **Camada de Repositório (Repository)** para buscar ou persistir dados no banco.
5.  Retorna um resultado (um objeto, um array, um booleano) para o `Controller`.

## ⛔ O que NUNCA fazer em um Serviço

-   **NÃO acessar a `Request` HTTP:** Um Serviço NUNCA deve saber sobre `Request` ou `Response`. Ele não deve receber `$request` do Controller. Ele deve receber apenas os dados já validados (ex: `$request->validated()`). Isso o torna reutilizável em qualquer lugar (Controllers, Comandos Artisan, Jobs).
-   **NÃO retornar uma Resposta HTTP:** Um Serviço nunca deve retornar `response()->json(...)`. Ele deve retornar os _dados_ (ex: o objeto `$user` criado). O `Controller` é quem decide como formatar a resposta.
-   **NÃO executar queries diretas:** Um Serviço não deve usar `User::create()` ou `DB::table()`. Ele deve **delegar** essa tarefa para o Repositório apropriado (ex: `$this->userRepository->create($data)`).

**Lembre-se: Services são "executores" de regras de negócio, não "acessadores" de banco de dados.**

---

### 📝 Exemplo de um Bom Serviço

Veja um exemplo de um `UserService` para criar um novo usuário. Note como ele coordena múltiplas ações (criar o usuário, enviar um e-mail) e como ele é "injetado" com o `UserRepository`.

```php
/*<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService
{
    /**
     * Injetamos o "Contrato" do Repositório,
     * não a implementação concreta.

    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Lógica de negócio para criar um novo usuário.
     *
     * @param array $data Dados já validados vindos do Controller.
     * @return \App\Models\User
     * @throws Exception

    public function createUser(array $data): \App\Models\User
    {
        try {
            // 1. Regra de Negócio: Criptografar a senha
            $data['password'] = Hash::make($data['password']);

            // 2. Delega a persistência para o Repositório
            $user = $this->userRepository->create($data);

            // 3. Orquestração: Dispara um evento de "usuário registrado"
            //    (Outra parte do sistema pode "ouvir" isso e enviar um e-mail)
            event(new UserRegistered($user));

            // 4. Retorna o dado bruto para o Controller
            return $user;

        } catch (Exception $e) {
            // Lida com erros, faz log, etc.
            // (Pode-se criar exceções customizadas, ex: UserCreationException)
            throw new Exception('Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    /**
     * Outra lógica de negócio...

    public function updateUserProfile(int $userId, array $data): \App\Models\User
    {
        // ...lógica para atualizar perfil...
        // 1. Chamar o repositório para buscar o usuário
        $user = $this->userRepository->find($userId);

        // 2. Regra de negócio: verificar se o e-mail mudou e precisa de reverificação
        if (isset($data['email']) && $data['email'] !== $user->email) {
            $data['email_verified_at'] = null;
        }

        // 3. Chamar o repositório para atualizar
        return $this->userRepository->update($user, $data);
    }
}
```
