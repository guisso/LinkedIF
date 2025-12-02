<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $oportunidade->titulo }} - LinkedIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5;
        }

        .navbar-brand {
            font-weight: bold;
            color: #198754 !important;
        }

        .detail-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .detail-section {
            border-bottom: 1px solid #e9ecef;
            padding: 1.5rem 0;
        }

        .detail-section:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .info-content {
            color: #6c757d;
        }

        .badge-skill {
            background-color: #e7f5ff;
            color: #0066cc;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .btn-candidatar {
            background-color: #198754;
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-candidatar:hover {
            background-color: #157347;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
        }

        .btn-voltar {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-briefcase-fill me-2"></i>LinkedIF
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <!-- Mensagens de feedback -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="detail-card p-4 mb-4">
                    <!-- Cabeçalho -->
                    <div class="detail-section">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h2 class="text-primary mb-2">{{ $oportunidade->titulo }}</h2>
                                <h5 class="text-muted">
                                    <i class="bi bi-building me-2"></i>{{ $oportunidade->editor->usuario->nome ?? 'N/A' }}
                                </h5>
                            </div>
                            <span class="badge bg-success fs-6 px-3 py-2">
                                {{ $oportunidade->tipoOportunidade->nome ?? 'N/A' }}
                            </span>
                        </div>
                        <p class="text-muted mb-2">
                            <i class="bi bi-code-square me-2"></i><strong>Código:</strong> {{ $oportunidade->codigo }}
                        </p>
                        <p class="text-muted mb-0">
                            <i class="bi bi-clock me-2"></i><strong>Publicado:</strong> {{ $oportunidade->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <!-- Descrição -->
                    <div class="detail-section">
                        <h5 class="info-label">
                            <i class="bi bi-file-text me-2"></i>Descrição
                        </h5>
                        <p class="info-content">{{ $oportunidade->descricao }}</p>
                    </div>

                    <!-- Requisitos -->
                    <div class="detail-section">
                        <h5 class="info-label">
                            <i class="bi bi-list-check me-2"></i>Requisitos
                        </h5>
                        <p class="info-content">{{ $oportunidade->requisitos }}</p>
                    </div>

                    <!-- Benefícios -->
                    @if($oportunidade->beneficios)
                    <div class="detail-section">
                        <h5 class="info-label">
                            <i class="bi bi-gift me-2"></i>Benefícios
                        </h5>
                        <p class="info-content">{{ $oportunidade->beneficios }}</p>
                    </div>
                    @endif

                    <!-- Informações adicionais -->
                    <div class="detail-section">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="info-label">
                                    <i class="bi bi-geo-alt me-2"></i>Modalidade
                                </h6>
                                <p class="info-content">{{ $oportunidade->modalidade->label() }}</p>
                            </div>

                            @if($oportunidade->localidade)
                            <div class="col-md-6 mb-3">
                                <h6 class="info-label">
                                    <i class="bi bi-pin-map me-2"></i>Localidade
                                </h6>
                                <p class="info-content">{{ $oportunidade->localidade }}</p>
                            </div>
                            @endif

                            <div class="col-md-6 mb-3">
                                <h6 class="info-label">
                                    <i class="bi bi-people me-2"></i>Número de Vagas
                                </h6>
                                <p class="info-content">{{ $oportunidade->vagas }}</p>
                            </div>

                            @if($oportunidade->remuneracao)
                            <div class="col-md-6 mb-3">
                                <h6 class="info-label">
                                    <i class="bi bi-currency-dollar me-2"></i>Remuneração
                                </h6>
                                <p class="info-content">R$ {{ number_format($oportunidade->remuneracao, 2, ',', '.') }}</p>
                            </div>
                            @endif

                            <div class="col-md-6 mb-3">
                                <h6 class="info-label">
                                    <i class="bi bi-calendar-event me-2"></i>Período
                                </h6>
                                <p class="info-content">
                                    {{ $oportunidade->inicio->format('d/m/Y') }} 
                                    @if($oportunidade->termino)
                                        até {{ $oportunidade->termino->format('d/m/Y') }}
                                    @else
                                        (Indeterminado)
                                    @endif
                                </p>
                            </div>

                            @if($oportunidade->horarioInicio && $oportunidade->horarioTermino)
                            <div class="col-md-6 mb-3">
                                <h6 class="info-label">
                                    <i class="bi bi-clock-history me-2"></i>Horário
                                </h6>
                                <p class="info-content">
                                    {{ $oportunidade->horarioInicio->format('H:i') }} às {{ $oportunidade->horarioTermino->format('H:i') }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Habilidades -->
                    @if($oportunidade->habilidades->count() > 0)
                    <div class="detail-section">
                        <h5 class="info-label mb-3">
                            <i class="bi bi-star me-2"></i>Habilidades Requeridas
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($oportunidade->habilidades as $habilidade)
                                <span class="badge-skill">{{ $habilidade->nome }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Informações do Editor -->
                    @if($oportunidade->editor->descricao)
                    <div class="detail-section">
                        <h5 class="info-label">
                            <i class="bi bi-info-circle me-2"></i>Sobre o Ofertante
                        </h5>
                        <p class="info-content">{{ $oportunidade->editor->descricao }}</p>
                    </div>
                    @endif
                </div>

                <!-- Botões de ação -->
                <div class="d-flex justify-content-center gap-3 mb-5">
                    @if($jaCandidatado)
                        <button type="button" class="btn btn-candidatar" disabled style="opacity: 0.6; cursor: not-allowed;">
                            <i class="bi bi-check-circle me-2"></i>Já Candidatado
                        </button>
                    @else
                        @auth('sanctum')
                            <form action="{{ route('candidaturas.store', $oportunidade->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-candidatar">
                                    <i class="bi bi-send me-2"></i>Candidatar-se
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login.form') }}" class="btn btn-candidatar">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Faça login para se candidatar
                            </a>
                        @endauth
                    @endif
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-voltar">
                        <i class="bi bi-arrow-left me-2"></i>Voltar para a tela inicial
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
