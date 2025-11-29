# 🔧 Camada de Configuração (Config)

Esta pasta contém todos os arquivos de configuração da aplicação. Cada arquivo (`app.php`, `database.php`, `auth.php`, `services.php`, etc.) define as opções padrão para um aspecto específico do framework.

## ✅ Responsabilidade Principal

A responsabilidade desta camada é servir como um **ponto de acesso central e seguro** para todas as variáveis de configuração do sistema.

Ela atua como uma "ponte" entre o arquivo `.env` (que guarda os "segredos" e variações de ambiente) e o resto da aplicação.

### A Relação Crucial: `config/` vs. `.env`

Esta é a regra mais importante do Laravel:

1.  **O Arquivo `.env` (Não-Versionado):**

    -   Fica na raiz do projeto.
    -   **Contém os segredos:** Senhas de banco de dados, chaves de API, e qualquer valor que **mude** entre ambientes (ex: `APP_DEBUG=true` em DEV, `APP_DEBUG=false` em PROD).
    -   **NUNCA DEVE SER "COMMITADO" NO GIT.** É específico para cada máquina/ambiente.

2.  **A Pasta `config/` (Versionada):**
    -   É "commitada" no Git.
    -   **Contém os valores padrão** e a _estrutura_ da configuração.
    -   Usa a função `env('MINHA_VARIAVEL', 'valor_padrao')` para **ler** o valor do arquivo `.env`. Se a variável não existir no `.env`, ele usa o `valor_padrao`.

**Exemplo (`config/database.php`):**

```php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'), // Lê do .env
    'port' => env('DB_PORT', '3306'), // Lê do .env
    'database' => env('DB_DATABASE', 'laravel'), // Lê do .env
    'username' => env('DB_USERNAME', 'root'), // Lê do .env
    'password' => env('DB_PASSWORD', ''), // Lê do .env
    // ...
],
```
