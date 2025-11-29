<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Perfis - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles (embutido para uso sem Vite/Tailwind) -->
    <style>
      :root{
        --color-bg:#FDFDFC;
        --color-text:#1b1b18;
        --muted:#706f6c;
        --primary:#1b1b18;
        --card-bg:#ffffff;
        --border:#e3e3e0;
      }
      *{box-sizing:border-box}
      body{margin:0;font-family:Inter,ui-sans-serif,system-ui,Helvetica,Arial,sans-serif;background:var(--color-bg);color:var(--color-text)}
      .container{max-width:1100px;margin-left:auto;margin-right:auto}
      .mx-auto{margin-left:auto;margin-right:auto}
      .px-4{padding-left:1rem;padding-right:1rem}
      .py-6{padding-top:1.5rem;padding-bottom:1.5rem}
      .py-12{padding-top:3rem;padding-bottom:3rem}
      .py-16{padding-top:4rem;padding-bottom:4rem}
      .text-5xl{font-size:3rem;line-height:1}
      .font-bold{font-weight:700}
      .text-xl{font-size:1.25rem}
      .gradient-hero{background:linear-gradient(90deg,#fff7f7,#fff);}
      .bg-background{background:transparent}
      .border-b{border-bottom:1px solid var(--border)}
      .sticky{position:sticky}
      .top-0{top:0}
      .z-40{z-index:40}
      .shadow-sm{box-shadow:0 1px 3px rgba(0,0,0,0.08)}
      .flex{display:flex}
      .flex-col{flex-direction:column}
      .flex-1{flex:1}
      .items-center{align-items:center}
      .justify-center{justify-content:center}
      .gap-4{gap:1rem}
      .relative{position:relative}
      .absolute{position:absolute}
      .left-3{left:0.75rem}
      .top-1\/2{top:50%}
      .-translate-y-1\/2{transform:translateY(-50%)}
      input[type=search], select, button{font:inherit}
      input[type=search]{width:100%;padding:0.5rem 0.75rem;border:1px solid var(--border);border-radius:8px}
      select{padding:0.5rem;border-radius:8px;border:1px solid var(--border)}
      button{border:0;padding:0.5rem 0.75rem;border-radius:8px;cursor:pointer}
      .bg-primary{background:var(--primary);color:#fff}
      .text-primary{color:var(--primary)}
      .text-muted-foreground{color:var(--muted)}
      .font-semibold{font-weight:600}
      .text-foreground{color:var(--color-text)}
      .grid{display:grid}
      .grid-cols-1{grid-template-columns:1fr}
      .gap-6{gap:1.5rem}
      .p-4{padding:1rem}
      .rounded-lg{border-radius:8px}
      .shadow-sm{box-shadow:0 1px 3px rgba(0,0,0,0.08)}
      .bg-white{background:var(--card-bg)}
      .object-cover{object-fit:cover}
      .w-16{width:4rem}
      .h-16{height:4rem}
      .rounded-full{border-radius:9999px}
      .text-sm{font-size:0.875rem}
      .mb-6{margin-bottom:1.5rem}
      .mb-8{margin-bottom:2rem}
      .mt-4{margin-top:1rem}
      .mb-3{margin-bottom:0.75rem}
      .mb-4{margin-bottom:1rem}
      .mb-1{margin-bottom:0.25rem}
      .max-w-2xl{max-width:40rem}
      footer{margin-top:2rem;padding:2rem 1rem}

      /* Responsive */
      @media (min-width:768px){
        .md\:grid-cols-2{grid-template-columns:repeat(2,1fr)}
        .md\:flex-row{flex-direction:row}
        .md\:w-\[200px\]{width:200px}
      }
      @media (min-width:1024px){
        .lg\:grid-cols-3{grid-template-columns:repeat(3,1fr)}
        .lg\:w-\[438px\]{width:438px}
      }
    </style>
  </head>

  <body class="min-h-screen flex flex-col bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">
    <header class="w-full">
      @if (Route::has('login'))
        <nav class="container mx-auto px-4 py-4 flex justify-end">
          @auth
            <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 border text-[#1b1b18] rounded-sm">Dashboard</a>
          @else
            <a href="{{ route('login') }}" class="inline-block px-5 py-1.5">Log in</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="inline-block px-5 py-1.5">Register</a>
            @endif
          @endauth
        </nav>
      @endif
    </header>

    <section class="gradient-hero text-primary-foreground py-16">
      <div class="container mx-auto px-4">
        <h1 class="text-5xl font-bold mb-4">Perfis da Comunidade</h1>
        <p class="text-xl max-w-2xl">Conheça estudantes, professores e ex-alunos do IFNMG</p>
      </div>
    </section>

    <section class="bg-background border-b border-border sticky top-0 z-40 shadow-sm">
      <div class="container mx-auto px-4 py-6">
        <form method="GET" action="{{ route('perfis.index') }}" class="flex flex-col md:flex-row gap-4">
          <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/></svg>
            <input
              type="search"
              name="search"
              value="{{ request('search', '') }}"
              placeholder="Buscar por nome ou área de interesse..."
              class="pl-10 w-full rounded-md border px-3 py-2"
            />
          </div>

          <select name="filter" class="md:w-[200px] rounded-md border px-3 py-2">
            <option value="all" {{ request('filter', 'all') === 'all' ? 'selected' : '' }}>Todos</option>
            <option value="student" {{ request('filter') === 'student' ? 'selected' : '' }}>Estudantes</option>
            <option value="teacher" {{ request('filter') === 'teacher' ? 'selected' : '' }}>Professores</option>
            <option value="company" {{ request('filter') === 'company' ? 'selected' : '' }}>Empresas</option>
          </select>

          <div class="md:w-[120px]">
            <button type="submit" class="w-full rounded-md bg-primary text-white px-3 py-2">Filtrar</button>
          </div>
        </form>
      </div>
    </section>

    <main class="flex-1 py-12 bg-muted">
      <div class="container mx-auto px-4">
        {{-- Loading server-side is usually instant; controller can pass a $loading flag if needed --}}
        <div class="mb-6">
          <p class="text-muted-foreground">Exibindo <span class="font-semibold text-foreground">{{ isset($profiles) ? $profiles->count() : 0 }}</span> perfis</p>
        </div>

        {{-- Seção de demonstração Tailwind (apenas para desenvolvimento) --}}
        <div class="mb-8">
          <h4 class="mb-3 font-medium">Demo Tailwind</h4>
          <div class="flex flex-wrap gap-3 mb-4">
            <button class="px-4 py-2 rounded bg-primary text-white">Primary</button>
            <button class="px-4 py-2 rounded bg-white border text-[#1b1b18]">Secondary</button>
            <button class="px-4 py-2 rounded bg-green-500 text-white">Success</button>
            <button class="px-4 py-2 rounded bg-yellow-400 text-white">Warning</button>
            <span class="inline-flex items-center px-2 py-1 bg-muted text-sm rounded">Badge</span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 bg-white rounded shadow-sm">
              <h5 class="font-semibold">Card 1</h5>
              <p class="text-sm text-muted-foreground">Exemplo de texto no card para validar espaçamento e tipografia.</p>
            </div>
            <div class="p-4 bg-white rounded shadow-sm">
              <h5 class="font-semibold">Card 2</h5>
              <p class="text-sm text-muted-foreground">Outro card de demonstração.</p>
            </div>
            <div class="p-4 bg-white rounded shadow-sm">
              <h5 class="font-semibold">Card 3</h5>
              <p class="text-sm text-muted-foreground">Terceiro card para checar grid responsivo.</p>
            </div>
          </div>
        </div>

        @if (!isset($profiles) || $profiles->count() === 0)
          <div class="text-center py-20">
            <p class="text-muted-foreground text-lg">Nenhum perfil encontrado com os filtros selecionados.</p>
          </div>
        @else
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($profiles as $profile)
              <article class="bg-white dark:bg-[#161615] p-4 rounded-lg shadow-sm">
                <div class="flex items-center gap-4">
                  <img src="{{ $profile->avatar_url ?? asset('images/avatar-placeholder.png') }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover" />
                  <div>
                    <h3 class="font-semibold">{{ $profile->full_name ?? $profile->name ?? '—' }}</h3>
                    <p class="text-sm text-muted-foreground">{{ $profile->user_type ?? '' }}</p>
                  </div>
                </div>

                @if (!empty($profile->bio))
                  <p class="mt-3 text-sm text-muted-foreground">{{ Str::limit($profile->bio, 140) }}</p>
                @endif

                <div class="mt-4 flex items-center justify-between">
                  <div class="text-sm text-muted-foreground">Visibilidade: {{ $profile->visibility ?? 'public' }}</div>
                  <a href="{{ route('perfis.show', ['perfil' => $profile->id]) }}" class="text-primary underline">Ver perfil</a>
                </div>
              </article>
            @endforeach
          </div>
        @endif
      </div>
    </main>

    <footer class="container mx-auto px-4 py-8 text-sm text-muted-foreground">
      <div class="text-center">&copy; {{ date('Y') }} {{ config('app.name') }}</div>
    </footer>
  </body>
</html>
