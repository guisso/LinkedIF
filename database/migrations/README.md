# 💾 Camada de Migrações (Migrations)

Esta pasta contém o **controle de versão do nosso esquema de banco de dados**. Pense nela como o "histórico de construção" da nossa base de dados.

Uma "migration" é uma classe PHP que descreve uma mudança no banco de dados (seja criar uma tabela, adicionar uma coluna, remover um índice, etc.). Em vez de compartilhar arquivos `.sql` complexos, nós compartilhamos essas classes, e o Laravel as executa em ordem para construir ou modificar o banco de dados de forma programática.

## ✅ Responsabilidade Principal

A responsabilidade desta camada é definir e modificar a **estrutura (schema)** do banco de dados de forma incremental e reversível.

Cada arquivo de migration contém dois métodos principais:

-   **`up()`:** ⬆️

    -   **O que faz:** Descreve a mudança que queremos **aplicar** ao banco.
    -   **Comando:** Executado quando rodamos `php artisan migrate`.
    -   **Exemplo:** `Schema::create('users', ...)` ou `Schema::table('users', function ($table) { $table->string('avatar'); });`

-   **`down()`:** ⬇️
    -   **O que faz:** Descreve como **reverter** (desfazer) a mudança feita pelo método `up()`.
    -   **Comando:** Executado quando rodamos `php artisan migrate:rollback`.
    -   **Exemplo:** `Schema::dropIfExists('users')` ou `Schema::table('users', function ($table) { $table->dropColumn('avatar'); });`

Ter um método `down()` funcional é crucial para a saúde do projeto, permitindo-nos reverter mudanças sem destruir o banco de dados manualmente.

---

## ⛔ As Regras de Ouro (MUITO IMPORTANTE)

Para que as migrations funcionem em equipe, algumas regras NUNCA devem ser quebradas:

1.  **NUNCA edite uma Migration que já foi enviada (commitada) para o repositório principal (`main`/`develop`) e usada por outros desenvolvedores!**

    -   **Problema:** Se você editar uma migration antiga, ela não será executada novamente na sua máquina, mas causará erros graves ou inconsistências no banco de dados de outros desenvolvedores quando eles baixarem seu código.
    -   **Solução Correta:** Se você precisa alterar uma tabela que já existe, crie uma **NOVA** migration para aplicar essa mudança.
    -   **Comando:** `php artisan make:migration add_bio_column_to_users_table --table=users`

2.  **NUNCA coloque DADOS dentro de uma Migration.**
    -   Migrations são para **Estrutura (Schema)**.
    -   Para popular o banco com dados (dados de teste, dados padrão, etc.), use a camada de **Seeders** (`database/seeders/`).

---

### 💡 Migrations vs. Seeders: Qual a diferença?

-   **Migrations (Esta pasta):** O "projeto" da casa.
    -   Diz onde vão as paredes, portas e janelas (cria tabelas, colunas, índices).
-   **Seeders (`database/seeders`):** A "mobília" da casa.
    -   Coloca a cama, a mesa e o sofá (insere os dados, como `User::create([...])`).

---

### ⌨️ Comandos Mais Comuns

-   **Criar uma nova migration para criar uma tabela:**
    `php artisan make:migration create_posts_table --create=posts`

-   **Criar uma nova migration para alterar uma tabela existente:**
    `php artisan make:migration add_published_at_to_posts_table --table=posts`

-   **Executar todas as migrations pendentes:**
    `php artisan migrate`

-   **Reverter a última "leva" de migrations:**
    `php artisan migrate:rollback`

-   **Reverter TUDO e re-executar TUDO (Destrutivo! Só em DEV):**

    -   Isso apaga TODOS os dados do banco.
    -   `php artisan migrate:fresh`

-   **Reverter TUDO, re-executar TUDO e popular com Seeders (A "bala de prata" em desenvolvimento):**
    -   `php artisan migrate:fresh --seed`
