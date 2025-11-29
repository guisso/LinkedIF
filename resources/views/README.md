# 🖥️ Camada de Visualização (Views)

Esta pasta contém todos os arquivos de template da nossa aplicação. É a camada de **Apresentação** (o "V" do MVC - Model-View-Controller).

Os arquivos aqui são escritos usando a engine de template **Blade** do Laravel, que nos permite escrever HTML de forma mais limpa, usar herança de layouts, componentes e diretivas PHP simples.

## ✅ Responsabilidade Principal

A única responsabilidade da camada de View é **exibir os dados** que foram preparados e enviados pelo `Controller`.

O trabalho de uma View é:

1.  Renderizar o HTML da página.
2.  Exibir as variáveis (dados) que o Controller passou para ela (ex: `{{ $user->name }}`).
3.  Usar **lógica de apresentação** simples, como laços (`@foreach`) para listar itens ou condicionais (`@if`) para mostrar/esconder elementos.

## ⛔ A REGRA DE OURO: Views Devem Ser "Burras"

Para manter nossa arquitetura limpa e testável, a camada de View **NUNCA DEVE**:

-   **NUNCA Fazer Queries no Banco de Dados:** É uma violação grave de arquitetura fazer `\App\Models\User::find(1)` ou `DB::table(...)` dentro de um arquivo `.blade.php`. **Toda a busca de dados é responsabilidade dos Repositórios**, orquestrada pelos Serviços e entregue pelo Controller.
-   **NUNCA Conter Lógica de Negócio:** Nenhum cálculo complexo, nenhuma verificação de regra de negócio, nenhuma manipulação de dados. (Ex: calcular um total de um carrinho, formatar um dado complexo). Isso deve vir **pronto** do Service ou do Model (usando Acessors).
-   **NUNCA Chamar Serviços:** Uma View não deve ter conhecimento da camada de Serviço.

**Pense assim: A View é uma "atriz" que apenas lê o script (`$dados`) que o Diretor (`Controller`) lhe entregou.**

---

### 💡 Melhores Práticas de Organização

Para manter esta pasta organizada, seguimos as seguintes convenções:

1.  **Pastas por Recurso:** Agrupe as views por recurso ou "entidade".

    -   `views/users/` (com `index.blade.php`, `create.blade.php`, `show.blade.php`, etc.)
    -   `views/posts/`
    -   `views/dashboard/`

2.  **Layouts (`/layouts`):**
    Contém os "esqueletos" principais da nossa aplicação (ex: `app.blade.php`). Outras views irão "estender" (`@extends`) este layout para herdar o `<html>`, `<head>`, `<body>`, navbar e footer, preenchendo apenas o conteúdo principal (`@section('content')`).

3.  **Partials (Parciais) (`/partials`):**
    Contém pedaços de HTML reutilizáveis que _não_ são componentes isolados, mas que são incluídos (`@include`) em várias páginas (ex: `_navbar.blade.php`, `_footer.blade.php`).

4.  **Componentes (`/components`):**
    Esta é a forma **moderna e preferida** de criar elementos reutilizáveis e isolados (ex: botões, modais, caixas de alerta, inputs de formulário). São usados com a sintaxe `<x-nome-do-componente>`.

5.  **E-mails (`/emails`):**
    Todos os templates Blade usados para enviar e-mails (Mailable classes) devem ficar aqui, e não misturados com as views da aplicação.

### 🔐 Segurança: Evitando XSS

O Blade nos protege automaticamente contra ataques de Cross-Site Scripting (XSS) usando a sintaxe de chaves duplas:

-   **`{{ $variavel }}`** -> **SEGURO.** O Laravel irá "escapar" o conteúdo, convertendo tags HTML (como `<script>`) em texto puro, impedindo sua execução. Use isto 99% das vezes.

-   **`{!! $variavel !!}`** -> **PERIGOSO.** O Laravel irá renderizar o conteúdo como HTML bruto. **NUNCA** use isso com dados que vieram de um usuário (como um comentário ou um nome). O único uso aceitável é para exibir conteúdo que _você_ gerou e salvou através de um editor Rich Text (como o TinyMCE) e que já foi sanitizado no backend.

### nota sobre APIs

Se este projeto for uma **API pura (headless)**, esta pasta `views` será muito pequena. Ela será usada apenas para coisas como:

-   Templates de e-mail (confirmação de conta, reset de senha).
-   Páginas de documentação da API (se houver).
