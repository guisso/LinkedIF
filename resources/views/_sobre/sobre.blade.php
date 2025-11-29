<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sobre - {{ config('app.name', 'LinkedIF') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <style>
            :root {
                --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                
                /* Light Mode */
                --color-bg: #ffffff;
                --color-bg-muted: hsl(210, 20%, 98%);
                --color-text: hsl(150, 100%, 15%); /* --foreground */
                --color-text-muted: hsl(210, 10%, 40%); /* --muted-foreground */
                
                /* Green Scheme (IFNMG) */
                --color-primary: hsl(150, 100%, 20%);
                --color-primary-foreground: #ffffff;
                --color-primary-light: hsl(150, 60%, 95%);
                --color-border: hsl(210, 20%, 90%);
                --color-card-bg: #ffffff;
                --color-accent: hsl(150, 60%, 50%);
                
                /* Gradient */
                --gradient-start: hsl(150, 100%, 20%);
                --gradient-end: hsl(150, 100%, 30%);
            }

            @media (prefers-color-scheme: dark) {
                :root {
                    --color-bg: hsl(150, 100%, 5%);
                    --color-bg-muted: hsl(150, 20%, 15%);
                    --color-text: #f9fafb;
                    --color-text-muted: hsl(210, 10%, 60%);
                    
                    --color-primary: hsl(150, 80%, 45%);
                    --color-primary-foreground: hsl(150, 100%, 5%);
                    --color-primary-light: hsl(150, 60%, 15%);
                    --color-border: hsl(150, 20%, 20%);
                    --color-card-bg: hsl(150, 100%, 8%);
                    --color-accent: hsl(150, 60%, 40%);
                    
                    --gradient-start: hsl(150, 100%, 20%);
                    --gradient-end: hsl(150, 80%, 25%);
                }
            }

            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: var(--font-sans);
                background-color: var(--color-bg);
                color: var(--color-text);
                line-height: 1.6;
                -webkit-font-smoothing: antialiased;
            }

            /* Utilities */
            .container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 1.5rem;
            }

            .text-center { text-align: center; }
            .mb-2 { margin-bottom: 0.5rem; }
            .mb-4 { margin-bottom: 1rem; }
            .mb-6 { margin-bottom: 1.5rem; }
            .mb-8 { margin-bottom: 2rem; }
            .mb-12 { margin-bottom: 3rem; }
            
            .text-primary { color: var(--color-accent); }
            .text-muted { color: var(--color-text-muted); }
            .font-bold { font-weight: 700; }
            .font-semibold { font-weight: 600; }

            /* Header */
            .header {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                padding: 1.5rem 0;
                z-index: 10;
            }
            
            .nav {
                display: flex;
                justify-content: flex-end;
            }

            .nav-link {
                color: var(--color-text);
                text-decoration: none;
                font-weight: 500;
                margin-left: 1.5rem;
                transition: color 0.2s;
            }
            
            .nav-link:hover {
                color: var(--color-accent);
            }

            .hero-nav-link {
                color: var(--color-primary-foreground);
            }

            /* Sections */
            section {
                padding: 5rem 0;
            }

            .bg-muted {
                background-color: var(--color-bg-muted);
            }

            /* Hero */
            .hero {
                background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
                color: var(--color-primary-foreground);
                padding: 8rem 0 6rem;
                text-align: center;
            }

            .hero h1 {
                font-size: 3rem;
                line-height: 1.2;
                margin-bottom: 1.5rem;
            }

            .hero p {
                font-size: 1.25rem;
                max-width: 48rem;
                margin: 0 auto;
                opacity: 0.9;
            }

            /* Grids */
            .grid {
                display: grid;
                gap: 2rem;
            }

            .grid-2 { grid-template-columns: 1fr; }
            .grid-3 { grid-template-columns: 1fr; }
            .grid-4 { grid-template-columns: 1fr; }

            @media (min-width: 768px) {
                .grid-2 { grid-template-columns: repeat(2, 1fr); }
                .grid-3 { grid-template-columns: repeat(3, 1fr); }
                .grid-4 { grid-template-columns: repeat(2, 1fr); }
                .hero h1 { font-size: 4rem; }
            }

            @media (min-width: 1024px) {
                .grid-4 { grid-template-columns: repeat(4, 1fr); }
            }

            /* Cards */
            .card {
                background-color: var(--color-card-bg);
                border: 1px solid var(--color-border);
                border-radius: 0.75rem;
                padding: 2rem;
                transition: transform 0.2s, box-shadow 0.2s;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            }

            .card-icon-wrapper {
                width: 4rem;
                height: 4rem;
                background-color: var(--color-primary-light);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.5rem;
                color: var(--color-accent);
            }

            .card h3 {
                font-size: 1.25rem;
                margin-bottom: 0.75rem;
                color: var(--color-text);
            }

            .card p {
                color: var(--color-text-muted);
                font-size: 1rem;
            }

            /* Stats */
            .stats-section {
                background-color: var(--color-primary);
                color: var(--color-primary-foreground);
            }

            .stat-item p:first-child {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .stat-item p:last-child {
                opacity: 0.8;
                font-size: 1.125rem;
            }

            /* Buttons */
            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.2s;
                cursor: pointer;
                font-size: 1rem;
            }

            .btn-primary {
                background-color: var(--color-primary);
                color: var(--color-primary-foreground);
                border: 1px solid transparent;
            }
            
            .btn-primary:hover {
                opacity: 0.9;
            }

            .btn-outline {
                background-color: rgba(255, 255, 255, 0.1);
                color: #ffffff;
                border: 1px solid rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(4px);
            }

            .btn-outline:hover {
                background-color: rgba(255, 255, 255, 0.2);
            }
            
            .btn-full {
                width: 100%;
            }

            /* Step Number */
            .step-number {
                width: 3rem;
                height: 3rem;
                background-color: var(--color-primary);
                color: var(--color-primary-foreground);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            /* Icons */
            .icon {
                width: 2rem;
                height: 2rem;
                stroke: currentColor;
                stroke-width: 2;
                stroke-linecap: round;
                stroke-linejoin: round;
                fill: none;
            }
            
            .icon-lg {
                width: 4rem;
                height: 4rem;
            }

            /* Footer */
            .footer {
                background-color: var(--color-bg);
                border-top: 1px solid var(--color-border);
                padding: 2rem 0;
                text-align: center;
                color: var(--color-text-muted);
            }
        </style>
    </head>
    <body>
        <header class="header">
            <div class="container">
                <nav class="nav">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="nav-link hero-nav-link">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="nav-link hero-nav-link">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-link hero-nav-link">Register</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1 class="mb-6">Sobre o Banco de Talentos</h1>
                <p>
                    Uma iniciativa do IFNMG - Campus Montes Claros para conectar nossa comunidade acadêmica ao mercado de trabalho
                </p>
            </div>
        </section>

        <!-- What is Section -->
        <section>
            <div class="container">
                <div style="max-width: 56rem; margin: 0 auto;">
                    <h2 class="text-center mb-6" style="font-size: 2.25rem; font-weight: 700;">O que é o Banco de Talentos?</h2>
                    <div class="text-muted" style="font-size: 1.125rem; line-height: 1.8;">
                        <p class="mb-4">
                            O <strong class="text-primary">Banco de Talentos IFNMG</strong> é uma plataforma digital desenvolvida para promover a conexão entre estudantes, ex-alunos, professores e empresas. Nosso objetivo é facilitar a empregabilidade e criar oportunidades de crescimento profissional para toda a comunidade acadêmica.
                        </p>
                        <p class="mb-4">
                            Através desta plataforma, estudantes e ex-alunos podem criar perfis profissionais completos, destacando suas competências técnicas, experiências e projetos desenvolvidos durante sua formação. Empresas e professores, por sua vez, têm acesso a um banco de talentos qualificados, prontos para contribuir com o mercado de trabalho e projetos acadêmicos.
                        </p>
                        <p>
                            Mais do que uma simples plataforma de vagas, o Banco de Talentos representa o compromisso do IFNMG com o futuro profissional de seus alunos e com o desenvolvimento econômico da região.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="bg-muted">
            <div class="container">
                <h2 class="text-center mb-12" style="font-size: 2.25rem; font-weight: 700;">Funcionalidades da Plataforma</h2>
                <div class="grid grid-4">
                    <!-- Feature 1 -->
                    <div class="card">
                        <div class="card-icon-wrapper">
                            <svg class="icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <h3>Perfis Profissionais</h3>
                        <p>Estudantes e ex-alunos criam perfis completos mostrando habilidades, experiências e projetos realizados.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="card">
                        <div class="card-icon-wrapper">
                            <svg class="icon" viewBox="0 0 24 24"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <h3>Vagas de Emprego</h3>
                        <p>Empresas publicam oportunidades alinhadas com as competências dos nossos alunos.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="card">
                        <div class="card-icon-wrapper">
                            <svg class="icon" viewBox="0 0 24 24"><path d="M22 10v6M2 10v6"/><path d="M12 22a7 7 0 0 1-7-7c0-2 2-3 2-3 0-3 3-5 5-5s5 2 5 5c0 0 2 1 2 3a7 7 0 0 1-7 7z"/><path d="M12 7v5"/></svg>
                        </div>
                        <h3>Conexão Acadêmica</h3>
                        <p>Professores encontram alunos para projetos de pesquisa, extensão e monitoria.</p>
                    </div>
                    <!-- Feature 4 -->
                    <div class="card">
                        <div class="card-icon-wrapper">
                            <svg class="icon" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
                        </div>
                        <h3>Parcerias Empresariais</h3>
                        <p>Conexão direta entre instituição e mercado de trabalho regional.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Principles Section -->
        <section>
            <div class="container">
                <h2 class="text-center mb-12" style="font-size: 2.25rem; font-weight: 700;">Nossos Princípios</h2>
                <div class="grid grid-3" style="max-width: 64rem; margin: 0 auto;">
                    <!-- Mission -->
                    <div class="text-center">
                        <div class="card-icon-wrapper" style="margin: 0 auto 1.5rem;">
                            <svg class="icon" style="width: 2.5rem; height: 2.5rem;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        </div>
                        <h3 class="font-bold mb-2" style="font-size: 1.5rem;">Missão</h3>
                        <p class="text-muted">Conectar talentos do IFNMG com oportunidades de crescimento profissional, fortalecendo a empregabilidade.</p>
                    </div>
                    <!-- Vision -->
                    <div class="text-center">
                        <div class="card-icon-wrapper" style="margin: 0 auto 1.5rem;">
                            <svg class="icon" style="width: 2.5rem; height: 2.5rem;" viewBox="0 0 24 24"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
                        </div>
                        <h3 class="font-bold mb-2" style="font-size: 1.5rem;">Visão</h3>
                        <p class="text-muted">Ser a principal plataforma de conexão entre instituição de ensino e mercado de trabalho no Norte de Minas.</p>
                    </div>
                    <!-- Values -->
                    <div class="text-center">
                        <div class="card-icon-wrapper" style="margin: 0 auto 1.5rem;">
                            <svg class="icon" style="width: 2.5rem; height: 2.5rem;" viewBox="0 0 24 24"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                        </div>
                        <h3 class="font-bold mb-2" style="font-size: 1.5rem;">Valores</h3>
                        <p class="text-muted">Transparência, qualidade, inclusão e compromisso com o desenvolvimento profissional.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <h2 class="text-center mb-12" style="font-size: 2.25rem; font-weight: 700;">Nossos Números</h2>
                <div class="grid grid-4" style="max-width: 64rem; margin: 0 auto;">
                    <div class="stat-item text-center">
                        <p>500+</p>
                        <p>Alunos Cadastrados</p>
                    </div>
                    <div class="stat-item text-center">
                        <p>120+</p>
                        <p>Vagas Publicadas</p>
                    </div>
                    <div class="stat-item text-center">
                        <p>80+</p>
                        <p>Empresas Parceiras</p>
                    </div>
                    <div class="stat-item text-center">
                        <p>350+</p>
                        <p>Contratações</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Participation Section -->
        <section class="bg-muted">
            <div class="container">
                <h2 class="text-center mb-12" style="font-size: 2.25rem; font-weight: 700;">Como Participar</h2>
                <div class="grid grid-3">
                    <!-- Students -->
                    <div class="card" style="align-items: flex-start; text-align: left;">
                        <div class="step-number">1</div>
                        <h3>Para Alunos e Ex-alunos</h3>
                        <p class="mb-6">Cadastre-se na plataforma, crie seu perfil profissional e comece a se candidatar a vagas ou ser encontrado por empresas.</p>
                        <a href="{{ url('/cadastro') }}" class="btn btn-primary btn-full">Criar Conta</a>
                    </div>
                    <!-- Companies -->
                    <div class="card" style="align-items: flex-start; text-align: left;">
                        <div class="step-number">2</div>
                        <h3>Para Empresas</h3>
                        <p class="mb-6">Registre sua empresa, publique vagas e encontre profissionais qualificados formados pelo IFNMG.</p>
                        <a href="{{ url('/empresa/cadastro') }}" class="btn btn-primary btn-full">Cadastrar Empresa</a>
                    </div>
                    <!-- Professors -->
                    <div class="card" style="align-items: flex-start; text-align: left;">
                        <div class="step-number">3</div>
                        <h3>Para Professores</h3>
                        <p class="mb-6">Acesse a plataforma para encontrar alunos com habilidades específicas para seus projetos acadêmicos.</p>
                        <a href="{{ url('/cadastro') }}" class="btn btn-primary btn-full">Acessar Plataforma</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section>
            <div class="container text-center">
                <h2 class="mb-6" style="font-size: 2.25rem; font-weight: 700;">Entre em Contato</h2>
                <p class="text-muted mb-8" style="font-size: 1.125rem;">
                    Tem dúvidas sobre o Banco de Talentos? Entre em contato conosco através dos canais oficiais do IFNMG.
                </p>
                <div class="mb-8 text-muted">
                    <p class="mb-2"><strong style="color: var(--color-text);">Endereço:</strong> IFNMG - Campus Montes Claros</p>
                    <p class="mb-2"><strong style="color: var(--color-text);">Telefone:</strong> (38) 3229-8100</p>
                    <p><strong style="color: var(--color-text);">E-mail:</strong> contato@ifnmg.edu.br</p>
                </div>
                <a href="#" class="btn btn-primary">Fale Conosco</a>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="hero">
            <div class="container">
                <svg class="icon icon-lg mb-6" viewBox="0 0 24 24" style="margin: 0 auto 1.5rem;"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                <h2 class="mb-4" style="font-size: 2.5rem; font-weight: 700;">Faça Parte Desta Comunidade</h2>
                <p class="mb-8" style="font-size: 1.25rem; opacity: 0.9;">
                    Junte-se a centenas de profissionais que já encontraram oportunidades através do Banco de Talentos IFNMG
                </p>
                <a href="{{ url('/cadastro') }}" class="btn btn-outline">Começar Agora</a>
            </div>
        </section>

        <footer class="footer">
            <div class="container">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'LinkedIF') }}. Todos os direitos reservados.</p>
            </div>
        </footer>
    </body>
</html>

