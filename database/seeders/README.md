# 🌱 Camada de Semeadores (Seeders)

Esta pasta contém as classes responsáveis por **popular (semear) o nosso banco de dados com dados**.

Enquanto as [Migrations](../migrations) constroem a _estrutura_ (as tabelas), os **Seeders** inserem os _dados_ (as linhas) dentro dessas tabelas.

## ✅ Responsabilidade Principal

A responsabilidade de um Seeder é inserir dados no banco de dados. Isso tem três propósitos principais:

1.  **Ambiente de Desenvolvimento (DEV):** Criar um conjunto de dados falsos (mas realistas) para que os desenvolvedores possam construir e testar visualmente as funcionalidades. (Ex: criar 10 usuários falsos, 50 posts, 100 comentários).
2.  **Testes Automatizados (CI/CD):** Criar um estado "limpo" e conhecido no banco de dados antes de cada execução de teste automatizado.
3.  **Dados Padrão de Produção (PROD):** (Uso menos comum, mas importante) Inserir dados iniciais que a aplicação _precisa_ para funcionar. (Ex: uma lista de "Tipos de Usuário" como `admin`, `editor`, `cliente`; ou uma lista de "Categorias" padrão).

## ⛔ O que NUNCA fazer em um Seeder

-   **NÃO alterar a ESTRUTURA do banco:** Um Seeder NUNCA deve criar tabelas, adicionar colunas ou modificar índices. Isso é responsabilidade exclusiva das **[Migrations](../migrations)**.
-   **NÃO usar dados "frágeis":** Evite criar dados que dependam de IDs fixos (ex: `id: 1`), a menos que seja absolutamente necessário para dados padrão. Deixe o banco de dados auto-incrementar os IDs.

---

### 💡 Migrations vs. Seeders: Qual a diferença?

-   **Migrations (`database/migrations`):** O "projeto" da casa.
    -   Diz onde vão as paredes, portas e janelas (cria tabelas, colunas, índices).
-   **Seeders (Esta pasta):** A "mobília" da casa.
    -   Coloca a cama, a mesa e o sofá (insere os dados, como `User::create([...])`).

---

### 🏭 Factories (Fábricas): Onde a Mágica Acontece

Para criar dados falsos (Fake Data) de forma eficiente, nós não escrevemos a lógica de criação de dados diretamente nos Seeders. Nós usamos **Factories** (definidas em `database/factories/`).

-   **Factories (`database/factories/`):** São "receitas de bolo" que definem _como_ criar um modelo falso. Elas usam a biblioteca `Faker` para gerar dados aleatórios realistas.
-   **Seeders (Esta pasta):** São os "chefs" que _executam_ as receitas. Um Seeder diz: "Execute a receita `UserFactory` 50 vezes".

### 📝 Exemplo de um Bom Seeder

**1. A Factory (`database/factories/PostFactory.php`):**
A "receita" para criar um Post falso.

```php
/*<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // Para associar um post a um usuário aleatório

class PostFactory extends Factory
{
    /**
     * Define o estado padrão do modelo.
     *
     * @return array

    public function definition()
    {
        return [
            // 'user_id' será pego aleatoriamente de um usuário existente
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(6),
            'body' => $this->faker->paragraphs(3, true),
            'published_at' => $this->faker->optional()->dateTimeThisYear(),
        ];
    }
}
```
