<div align="center">

# LinkedIF 

Conectando talentos do Instituto Federal do Norte de Minas Gerais a oportunidades do mercado.

![GitHub last commit](https://img.shields.io/github/last-commit/guisso/LinkedIF)
![License](https://img.shields.io/github/license/guisso/LinkedIF)
![Issues](https://img.shields.io/github/issues/guisso/LinkedIF)
![Build](https://img.shields.io/github/actions/workflow/status/guisso/LinkedIF/ci.yml)
</div>

<br>

## 💡 Sobre o Projeto

O LinkedIF é uma plataforma desenvolvida como um ecossistema de conexões voltado à comunidade do IFNMG. Atua como uma ferramenta de banco de talentos — denominada Banco de Talentos/LinkedIF — cuja finalidade principal é mapear, organizar e divulgar as competências e habilidades dos estudantes e egressos da instituição.

O sistema cria um canal direto e eficiente para conectar o talento acadêmico ao mercado, facilitando a divulgação de vagas e projetos. Além disso, promove a interação entre os ofertantes de oportunidades (professores e empresas) e os talentos (alunos e ex-alunos), fortalecendo a conexão entre quem busca e quem oferece oportunidades.

### Objetivos estratégicos e operacionais da plataforma:
- Centralizar Oportunidades: Reunir em um ambiente unificado todas as vagas de estágio, emprego e projetos de pesquisa e extensão.
- Agilizar a Inserção Profissional: Possibilitar o acesso direto dos alunos ao mercado de trabalho, conectando-os a empresas que valorizam a formação técnica e acadêmica proporcionada pelo IFNMG.
- Estimular a Participação Acadêmica: Ampliar a visibilidade dos projetos institucionais, incentivando o engajamento estudantil em iniciativas de pesquisa e extensão.
- Aprimorar o Processo de Recrutamento: Tornar mais eficiente a divulgação de projetos e a seleção de talentos, reduzindo custos e tempo de contratação de bolsistas ou voluntários.
- Promover a Comunicação: Facilitar a interação direta entre alunos e ofertantes por meio de funcionalidades como mensagens e inscrições integradas.
- Fortalecer a Empregabilidade dos Egressos: Acompanhar a trajetória profissional dos ex-alunos e ampliar suas oportunidades no mercado, reforçando o prestígio institucional.


### Requisitos funcionais
- O sistema deverá permitir o cadastro de novos usuários e suas respectivas permissões
- O sistema deverá permitir a consulta, edição e exclusão de usuários e suas permissões
- O sistema deverá permitir o registro de informações sobre projetos (nome, descrição, datas, responsáveis, etc.)
- O sistema deverá permitir a consulta, edição e exclusão de informações de projetos
- O sistema deverá permitir o cadastro de requisitos com campos detalhados (ID, tipo, descrição, prioridade, fonte, status, etc.)
- O sistema deverá permitir a consulta, edição e exclusão de requisitos
- O sistema deverá permitir a associação de requisitos a projetos
- O sistema deverá permitir a geração de relatórios e métricas sobre os requisitos (por projeto, status, prioridade, etc.)
- O sistema deverá permitir a exportação dos relatórios e da lista de requisitos em formatos populares (PDF, XLSX, CSV)
- O sistema deverá ter um mecanismo de busca avançado para requisitos e projetos
- O sistema deverá manter um histórico de alterações em requisitos e projetos
- O sistema deverá fornecer uma interface intuitiva para visualização e gestão dos requisitos e projetos

<br>

## ⚙️ Tecnologias

Este projeto foi desenvolvido com as seguintes tecnologias:


- [TypeScript](https://www.typescriptlang.org/)
- [React](https://react.dev/)
- [Laravel](https://laravel.com/docs/12.x)

<br>


## 🧱 Estrutura

```
app/
├── Models/              → Entidades e regras de negócio
├── Http/
│   ├── Controllers/     → Lógica de controle e fluxo de dados
│   ├── Middleware/      → Autenticação e autorização
│   └── Requests/        → Validação de dados de entrada
├── Services/            → Regras de negócio e persistência (customizado)
├── Policies/            → Autorização por perfil
├── Providers/           → Configurações e serviços
resources/
├── views/               → Camada de visão (Blade templates)
routes/
├── web.php              → Rotas da aplicação
database/
├── migrations/          → Estrutura do banco de dados
├── seeders/             → Dados iniciais
config/
├── auth.php             → Configuração de autenticação
```

<br>

## 📝 Diagrama de classes

<img src="https://i.imgur.com/oXzxQYC.png" alt="diagrama de classes"/>

<br>

## 🤝 Equipe e Colaboradores

Este projeto está sendo desenvolvido e orientado pela seguinte equipe:

### Professores:

<div align="center">
  <table>
  <tr>
    <td align="center"><a href="https://github.com/guisso"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/guisso?v=4" width="100px;" alt=""/><br /><sub><b>Luis Guisso</b></sub></a><br /></td>

  </tr>
<table>
</table>
</div>

 ### Discentes (Desenvolvedores):

<div align="center">
<table>
  <tr>
    <td align="center"><a href="https://github.com/ArthurLincolnNM"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/ArthurLincolnNM?v=4" width="100px;" alt=""/><br /><sub><b>Arthur Lincoln Nascimento Medeiros</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/FilipeLSantos"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/FilipeLSantos?v=4" width="100px;" alt=""/><br /><sub><b>Filipe Lopes dos Santos</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/AnaLuizanc"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/AnaLuizanc?v=4" width="100px;" alt=""/><br /><sub><b>Ana Luiza Nobre Cordeiro</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/Felipe-Dev-MP"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/Felipe-Dev-MP?v=4" width="100px;" alt=""/><br /><sub><b>Felipe Pereira Madureira</b></sub></a><br /></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/Lucasfgm"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/Lucasfgm?v=4" width="100px;" alt=""/><br /><sub><b>Lucas Flávio Gabrich Marinho</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/Iago-RR"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/Iago-RR?v=4" width="100px;" alt=""/><br /><sub><b>Iago Ravide Rodrigues Maia</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/Emanuel9005"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/Emanuel9005?v=4" width="100px;" alt=""/><br /><sub><b>Emanuel de Oliveira Campanha</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/Lorena-Avelino"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/Lorena-Avelino?v=4" width="100px;" alt=""/><br /><sub><b>Lorena Avelino de Oliveira</b></sub></a><br /></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/StanFredy"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/StanFredy?v=4" width="100px;" alt=""/><br /><sub><b>Stanley Frederick Ribeiro Bispo</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/SarahEmanuelleAlvesLino"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/SarahEmanuelleAlvesLino?v=4" width="100px;" alt=""/><br /><sub><b>Sarah Emanuelle Alves Lino</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/malodex"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/malodex?v=4" width="100px;" alt=""/><br /><sub><b>Marcos Dias de Andrade</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/ThigasSantos"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/ThigasSantos?v=4" width="100px;" alt=""/><br /><sub><b>Thiago Evangelista dos Santos</b></sub></a><br /></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/warleyramires"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/warleyramires?v=4" width="100px;" alt=""/><br /><sub><b>Warley Ramires Gonçalves</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/olimontes"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/olimontes?v=4" width="100px;" alt=""/><br /><sub><b>Frank Gabriel Oliveira Montes</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/Gustavornd"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/Gustavornd?v=4" width="100px;" alt=""/><br /><sub><b>Gustavo Rafael Nunes Durães</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/tainararib"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/tainararib?v=4" width="100px;" alt=""/><br /><sub><b>Tainara Ribeiro Santos</b></sub></a><br /></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/biellts"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/biellts?v=4" width="100px;" alt=""/><br /><sub><b>Gabriel Francisco Siqueira de Andrade</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/SamuelParanhos"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/SamuelParanhos?v=4" width="100px;" alt=""/><br /><sub><b>Samuel de Paula Paranhos</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/IagoRochaDev"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/IagoRochaDev?v=4" width="100px;" alt=""/><br /><sub><b>Iago Rocha Oliveira</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/Kuiapd"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/Kuiapd?v=4" width="100px;" alt=""/><br /><sub><b>Pablo Daniel Silva Santos</b></sub></a><br /></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/Paulo-b2"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/Paulo-b2?v=4" width="100px;" alt=""/><br /><sub><b>Paulo Eduardo Nunes Ribeiro</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/Pedro-b2"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/Pedro-b2?v=4" width="100px;" alt=""/><br /><sub><b>Pedro Henrique Nunes Ribeiro</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/martinsallan"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/martinsallan?v=4" width="100px;" alt=""/><br /><sub><b>Allan Pinto Martins</b></sub></a><br /></td>
    <td align="center"><a href="https://github.com/VitorRibe"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/VitorRibe?v=4" width="100px;" alt=""/><br /><sub><b>João Vitor Ribeiro Botelho</b></sub></a><br /></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/odavimendes"><img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/odavimendes?v=4" width="100px;" alt=""/><br /><sub><b>Davi Silva Mendes</b></sub></a><br /></td>
  </tr>
</table>
</div>
  
