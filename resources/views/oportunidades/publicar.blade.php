<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Oportunidade - LinkedIF</title>
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

        .form-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            border-left: 4px solid #198754;
            padding-left: 12px;
            margin-bottom: 20px;
            color: #198754;
            font-weight: bold;
        }

        .required-label::after {
            content: " *";
            color: #dc3545;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/home"><i class="bi bi-briefcase-fill me-2"></i>LinkedIF</a>
            <div class="d-flex align-items-center">
                <a href="/home" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Voltar ao Feed
                </a>
            </div>
        </div>
    </nav>

    <!-- Formulário de Publicação -->
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Cabeçalho -->
                <div class="text-center mb-4">
                    <h2 class="text-success"><i class="bi bi-megaphone-fill me-2"></i>Publicar Nova Oportunidade</h2>
                    <p class="text-muted">Preencha os dados da vaga ou projeto que deseja divulgar</p>
                </div>

                <!-- Área de Alertas -->
                <div id="alert-area"></div>

                <!-- Formulário -->
                <form id="formPublicar" class="form-card p-4">

                    <!-- Seção: Informações Básicas -->
                    <h5 class="section-title">Informações Básicas</h5>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="titulo" class="form-label required-label">Título da Oportunidade</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" maxlength="120" required placeholder="Ex: Estágio em Desenvolvimento Web">
                            <div class="form-text">Máximo de 120 caracteres</div>
                        </div>

                        <div class="col-md-4">
                            <label for="tipo_oportunidade_id" class="form-label required-label">Tipo</label>
                            <select class="form-select" id="tipo_oportunidade_id" name="tipo_oportunidade_id" required>
                                <option value="">Selecione...</option>
                                <!-- Será preenchido via JavaScript -->
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label required-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4" maxlength="500" required placeholder="Descreva a oportunidade de forma clara e objetiva"></textarea>
                        <div class="form-text">Máximo de 500 caracteres</div>
                    </div>

                    <div class="mb-3">
                        <label for="requisitos" class="form-label required-label">Requisitos</label>
                        <textarea class="form-control" id="requisitos" name="requisitos" rows="3" maxlength="500" required placeholder="Ex: Conhecimento em PHP, Laravel, HTML, CSS"></textarea>
                        <div class="form-text">Máximo de 500 caracteres</div>
                    </div>

                    <div class="mb-4">
                        <label for="beneficios" class="form-label">Benefícios</label>
                        <textarea class="form-control" id="beneficios" name="beneficios" rows="2" maxlength="500" placeholder="Ex: Vale-transporte, certificado, possibilidade de efetivação"></textarea>
                        <div class="form-text">Opcional - Máximo de 500 caracteres</div>
                    </div>

                    <!-- Seção: Detalhes da Vaga -->
                    <h5 class="section-title">Detalhes da Vaga</h5>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="vagas" class="form-label">Número de Vagas</label>
                            <input type="number" class="form-control" id="vagas" name="vagas" min="1" max="999" value="1" required>
                        </div>

                        <div class="col-md-4">
                            <label for="remuneracao" class="form-label">Remuneração (R$)</label>
                            <input type="number" class="form-control" id="remuneracao" name="remuneracao" min="0" step="0.01" placeholder="0.00">
                            <div class="form-text">Opcional</div>
                        </div>

                        <div class="col-md-4">
                            <label for="modalidade" class="form-label required-label">Modalidade</label>
                            <select class="form-select" id="modalidade" name="modalidade" required>
                                <option value="">Selecione...</option>
                                <option value="1">Presencial</option>
                                <option value="2">Remoto</option>
                                <option value="3">Híbrido</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="localidade" class="form-label">Localidade</label>
                            <input type="text" class="form-control" id="localidade" name="localidade" maxlength="50" placeholder="Ex: Montes Claros - MG">
                        </div>

                        <div class="col-md-6">
                            <label for="escala" class="form-label">Escala (horas/semana)</label>
                            <input type="number" class="form-control" id="escala" name="escala" min="1" max="255" placeholder="Ex: 20">
                        </div>
                    </div>

                    <!-- Seção: Período e Horário -->
                    <h5 class="section-title">Período e Horário</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="inicio" class="form-label required-label">Data de Início</label>
                            <input type="date" class="form-control" id="inicio" name="inicio" required>
                        </div>

                        <div class="col-md-6">
                            <label for="termino" class="form-label">Data de Término</label>
                            <input type="date" class="form-control" id="termino" name="termino">
                            <div class="form-text">Opcional - Padrão: 60 dias</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="horario_inicio" class="form-label">Horário de Início</label>
                            <input type="time" class="form-control" id="horario_inicio" name="horario_inicio">
                            <div class="form-text">Opcional - Deixe vazio para horário flexível</div>
                        </div>

                        <div class="col-md-6">
                            <label for="horario_termino" class="form-label">Horário de Término</label>
                            <input type="time" class="form-control" id="horario_termino" name="horario_termino">
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='/home'">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success" id="btn-publicar">
                            <i class="bi bi-send-fill me-1"></i> Publicar Oportunidade
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const formPublicar = document.getElementById('formPublicar');
        const alertArea = document.getElementById('alert-area');
        const btnPublicar = document.getElementById('btn-publicar');
        const selectTipo = document.getElementById('tipo_oportunidade_id');

        // Carrega tipos de oportunidade ao carregar a página
        document.addEventListener('DOMContentLoaded', async () => {
            const token = localStorage.getItem('auth_token');

            if (!token) {
                window.location.href = '/login';
                return;
            }

            // Carrega tipos de oportunidade da API
            try {
                const response = await fetch('/api/v1/tipos-oportunidade', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    const tipos = result.data;

                    tipos.forEach(tipo => {
                        const option = document.createElement('option');
                        option.value = tipo.id;
                        option.textContent = tipo.nome;
                        selectTipo.appendChild(option);
                    });
                } else {
                    // Fallback: tipos manuais se a API falhar
                    const tiposExemplo = [
                        { id: 1, nome: 'Estágio' },
                        { id: 2, nome: 'Emprego' },
                        { id: 3, nome: 'Pesquisa' },
                        { id: 4, nome: 'Extensão' },
                        { id: 5, nome: 'Bolsa' },
                    ];

                    tiposExemplo.forEach(tipo => {
                        const option = document.createElement('option');
                        option.value = tipo.id;
                        option.textContent = tipo.nome;
                        selectTipo.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Erro ao carregar tipos:', error);
            }
        });

        // Submissão do formulário
        formPublicar.addEventListener('submit', async function (e) {
            e.preventDefault();

            // UI de carregamento
            btnPublicar.disabled = true;
            btnPublicar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Publicando...';
            alertArea.innerHTML = '';

            const token = localStorage.getItem('auth_token');

            if (!token) {
                window.location.href = '/login';
                return;
            }

            const formData = new FormData(formPublicar);
            const data = Object.fromEntries(formData.entries());

            // Remove campos vazios
            Object.keys(data).forEach(key => {
                if (data[key] === '' || data[key] === null) {
                    delete data[key];
                }
            });

            try {
                const response = await fetch('/api/v1/oportunidades', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': token
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    // Sucesso!
                    alertArea.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Sucesso!</strong> ${result.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;

                    // Limpa o formulário
                    formPublicar.reset();

                    // Redireciona após 2 segundos
                    setTimeout(() => {
                        window.location.href = '/home';
                    }, 2000);

                } else {
                    // Erro
                    let errorMsg = result.message || 'Erro ao publicar oportunidade.';

                    // Se houver erros de validação, exibe
                    if (result.errors) {
                        errorMsg += '<ul class="mb-0 mt-2">';
                        Object.values(result.errors).forEach(errors => {
                            errors.forEach(error => {
                                errorMsg += `<li>${error}</li>`;
                            });
                        });
                        errorMsg += '</ul>';
                    }

                    alertArea.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            ${errorMsg}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;

                    // Scroll para o topo
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }

            } catch (error) {
                alertArea.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Erro!</strong> Não foi possível conectar ao servidor.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
            } finally {
                // Restaura o botão
                btnPublicar.disabled = false;
                btnPublicar.innerHTML = '<i class="bi bi-send-fill me-1"></i> Publicar Oportunidade';
            }
        });

        // Define data mínima como hoje
        document.getElementById('inicio').min = new Date().toISOString().split('T')[0];
        document.getElementById('termino').min = new Date().toISOString().split('T')[0];
    </script>

</body>

</html>