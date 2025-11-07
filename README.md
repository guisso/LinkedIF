# LinkedIF — Banco de Talentos

Introdução
---
O objetivo principal do projeto é criar uma ferramenta de banco de talentos. Esta ferramenta permitirá que o instituto conheça as habilidades técnicas e competências dos seus alunos e ex-alunos, facilitando a divulgação de vagas de emprego, estágio e oportunidades em projetos de extensão e pesquisa. A ferramenta também ajudará os professores a encontrar alunos com perfis específicos para diversas necessidades.

Sumário
---
- [Visão Geral](#visão-geral)
- [Funcionalidades](#funcionalidades)
- [Orientações para Desenvolvedores](#orientações-para-desenvolvedores)
  - [Convenções de commits (Conventional Commits)](#convenções-de-commits-conventional-commits)
  - [Boas práticas de branches](#boas-práticas-de-branches)
  - [Estrutura sugerida de branches](#estrutura-sugerida-de-branches)
  - [Revisões de código e Pull Requests](#revisões-de-código-e-pull-requests)
- [Estrutura do repositório (exemplo)](#estrutura-do-repositório-exemplo)

Visão geral
---
LinkedIF é a implementação do banco de talentos do instituto, composto por frontend e backend que permitem:
- cadastro e manutenção de perfis de alunos e egressos;
- pesquisa e filtragem por habilidades, cursos, disponibilidade e localização;
- publicação e divulgação de vagas (emprego, estágio, projetos);
- associação de professores a demandas para encontrar perfis adequados.

Funcionalidades (exemplos)
---
- Autenticação (alunos, ex-alunos, professores, administradores)
- Cadastro de habilidades e validação de competências
- Feed de oportunidades e sistema de candidaturas
- Filtros avançados e tags por áreas de atuação
- Painel administrativo para gestão de vagas e usuários

Orientações para Desenvolvedores
---
Esta seção descreve práticas recomendadas para manter o repositório organizado, facilitar revisão e garantir qualidade.

Convenções de commits (Conventional Commits)
- Siga o estilo "Conventional Commits" para tornar o histórico legível e possibilitar releases automatizados.
- Formato: <tipo>(escopo opcional): descrição curta
- Tipos recomendados:
  - feat: nova funcionalidade
  - fix: correção de bug
  - docs: documentação apenas
  - style: formatação, espaços, ponto e vírgula; sem alteração de lógica
  - refactor: alteração de código que não corrige bug nem adiciona feature
  - perf: melhoria de performance
  - test: adicionar/ajustar testes
  - chore: tarefas de manutenção (build, CI, deps)
- Exemplos:
  - feat(auth): adicionar endpoint de login com JWT
  - fix(api): corrigir filtro por skills
  - docs(readme): atualizar seção de instalação
- Mensagem de commit:
  - seja curta e no imperativo (ex.: "Adicionar rota de logout")
  - corpo do commit (quando necessário): explique o porquê e o que foi feito, referências a issues (ex.: "Refs #42")
  - footer: informações sobre breaking changes quando houver (BREAKING CHANGE: ...)

Boas práticas de branches
- Tenha sempre uma branch principal estável e protegida (ex.: main ou master). Configure proteção de branch e revisões obrigatórias.
- Use uma branch por feature/bugfix/hotfix para facilitar revisão e reverts.
- Nomeie branches de forma clara e consistente: <escopo>/<tipo>-<descrição-curta>
  - exemplos de tipos: feat, fix, refactor, docs, test
  - exemplos:
    - backend/feat-login
    - frontend/feat-pagina-de-login
    - frontend/feat-pagina-de-oportunidades
    - backend/fix-sql-injection
- Mantenha seu branch sincronizado com a branch principal: rebase ou merge regularmente antes do PR.
- Não faça commits diretos na branch principal sem passar por PR.

Estrutura sugerida de branches (exemplo)
- main (branch principal protegida)
- backend (pasta/área do backend — não é obrigatório ser branch, aqui sugerimos prefixo para branches relacionadas ao backend)
- frontend (idem para frontend)
Estrutura de feature branches sugerida:
- /backend
  - backend/feat-autenticacao
  - backend/fix-validacao-campo
- /frontend
  - frontend/feat-pagina-de-login
  - frontend/feat-pagina-de-oportunidades
  - frontend/refactor-header

Observação sobre pastas vs branches:
- Use nomes de branch que reflitam área do código (backend/frontend) e a feature específica, como nos exemplos acima. A árvore de diretórios do repo deve conter /backend e /frontend, e as branches devem ser nomeadas conforme convenção para fácil identificação.

Revisões de código e Pull Requests
- Abra Pull Requests (PRs) descrevendo:
  - objetivo da mudança;
  - screenshots ou GIFs (para mudanças visuais);
  - como testar localmente (passos);
  - requisitos e checklist (testes, lint, build OK).
- Inclua links para issues relacionadas (ex.: "Closes #12").
- Solicite pelo menos 1-2 revisores (dependendo da criticidade).
- Peça revisão de arquitetura quando a mudança afetar integrações ou modelos de dados.
- Não faça merge até que:
  - CI esteja verde;
  - revisores aprovem;
  - conflitos com a branch principal estejam resolvidos.

Estrutura do repositório (exemplo)
---
- /backend
  - README.md (backend)
  - src/
  - tests/
  - Dockerfile
- /frontend
  - README.md (frontend)
  - src/
  - public/
  - tests/
- /docs
- .github/workflows/ (CI)
- .env.example
- README.md
- LICENSE

Contribuição
---
- Abra uma issue antes de iniciar mudanças grandes para alinhar a solução.
- Siga as orientações de branches e commits.
- Execute testes localmente e garanta que o CI passe.
- Mantenha PRs pequenos e focados.