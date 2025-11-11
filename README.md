# IFNMG Connect

Plataforma de conexão entre estudantes, ex-alunos, professores e empresas do IFNMG Campus Montes Claros.

## 📋 Sobre o Projeto

O IFNMG Connect é uma aplicação frontend desenvolvida para facilitar a conexão entre a comunidade acadêmica do IFNMG e o mercado de trabalho.

## 🏗️ Arquitetura do Projeto

O projeto é uma aplicação frontend React + TypeScript:

```
ifnmgs-connect/
├── src/              # Código fonte da aplicação
│   ├── components/   # Componentes React
│   ├── pages/        # Páginas da aplicação
│   ├── hooks/        # Custom hooks
│   └── lib/          # Utilitários
└── public/           # Arquivos estáticos
```

### Tecnologias

- **Framework**: React 18 com TypeScript
- **Build Tool**: Vite
- **UI Components**: shadcn/ui + Tailwind CSS
- **Roteamento**: React Router DOM
- **Formulários**: React Hook Form + Zod
- **Estilização**: Tailwind CSS + Tailwind Animate

## 🚀 Como Executar o Projeto

### Pré-requisitos

- Node.js 18+ instalado
- npm ou bun

### 1. Clone o repositório

```bash
git clone https://github.com/AnaLuizanc/ifnmgs-connect.git
cd ifnmgs-connect
```

### 2. Instale as dependências

```bash
npm install
```

### 3. Execute o servidor de desenvolvimento

```bash
npm run dev
```

A aplicação estará disponível em `http://localhost:5173`

## 🛠️ Tecnologias Utilizadas

- React 18
- TypeScript
- Vite
- Tailwind CSS
- shadcn/ui (Componentes UI baseados em Radix UI)
- React Router DOM
- React Hook Form
- Zod (Validação de schemas)
- Lucide React (Ícones)
- Sonner (Toast notifications)

## 📁 Estrutura de Pastas

```
src/
├── components/      # Componentes React reutilizáveis
│   ├── ui/         # Componentes UI do shadcn
│   ├── Navbar.tsx  # Barra de navegação
│   ├── Footer.tsx  # Rodapé
│   └── ...         # Outros componentes
├── pages/          # Páginas da aplicação
│   ├── Index.tsx   # Página inicial
│   ├── Auth.tsx    # Login/Cadastro
│   ├── Sobre.tsx   # Sobre o projeto
│   └── ...         # Outras páginas
├── hooks/          # Custom hooks
│   └── use-mobile.tsx
├── lib/            # Utilitários
│   └── utils.ts    # Funções auxiliares
└── assets/         # Imagens e recursos estáticos
```

## 🤝 Como Contribuir

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Add: Minha nova feature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

## 📝 Licença

ISC

## 👥 Autores

- Ana Luiza

## 🔗 Links Úteis

- [Lovable Project](https://lovable.dev/projects/4b40d228-6f06-4929-91bc-b892fa43dd85)
- [React Documentation](https://react.dev)
- [Vite Documentation](https://vitejs.dev)
- [shadcn/ui Documentation](https://ui.shadcn.com)
- [Tailwind CSS Documentation](https://tailwindcss.com)
