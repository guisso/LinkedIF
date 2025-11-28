<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatar-se à Vaga - LinkedIF</title>
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

<!-- Formulário de Candidatura -->
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Cabeçalho -->
            <div class="text-center mb-4">
                <h2 class="text-success"><i class="bi bi-person-check-fill me-2"></i>Candidatar-se à Vaga</h2>
                <p class="text-muted">Preencha seus dados para se candidatar a esta oportunidade</p>
            </div>

            <!-- Informações da Vaga -->
            <div class="form-card p-4 mb-4">
                <h5 class="section-title">Informações da Vaga</h5>
                <div id="vaga-info">
                    <div class="placeholder-glow">
                        <span class="placeholder col-8"></span>
                        <span class="placeholder col-6"></span>
                        <span class="placeholder col-4"></span>
                    </div>
                </div>
            </div>

            <!-- Área de Alertas -->
            <div id="alert-area"></div>

            <!-- Formulário -->
            <form id="formCandidatar" class="form-card p-4">

                <!-- Seção: Informações Pessoais -->
                <h5 class="section-title">Informações Pessoais</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nome" class="form-label required-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" maxlength="100" required
                               placeholder="Seu nome completo">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label required-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="100" required
                               placeholder="seu.email@exemplo.com">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefone" class="form-label required-label">Telefone/WhatsApp</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" maxlength="20" required
                               placeholder="(31) 99999-9999">
                    </div>
                    <div class="col-md-6">
                        <label for="curso" class="form-label required-label">Curso</label>
                        <input type="text" class="form-control" id="curso" name="curso" maxlength="100" required
                               placeholder="Ex: Sistemas de Informação">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="periodo" class="form-label required-label">Período Atual</label>
                        <select class="form-select" id="periodo" name="periodo" required>
                            <option value="">Selecione...</option>
                            <option value="1">1º Período</option>
                            <option value="2">2º Período</option>
                            <option value="3">3º Período</option>
                            <option value="4">4º Período</option>
                            <option value="5">5º Período</option>
                            <option value="6">6º Período</option>
                            <option value="7">7º Período</option>
                            <option value="8">8º Período</option>
                            <option value="9">9º Período</option>
                            <option value="10">10º Período</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="linkedin" class="form-label">LinkedIn</label>
                        <input type="url" class="form-control" id="linkedin" name="linkedin"
                               placeholder="https://linkedin.com/in/seuperfil">
                        <div class="form-text">Opcional</div>
                    </div>
                </div>

                <!-- Seção: Experiência e Qualificações -->
                <h5 class="section-title">Experiência e Qualificações</h5>

                <div class="mb-3">
                    <label for="experiencia" class="form-label">Experiência Profissional</label>
                    <textarea class="form-control" id="experiencia" name="experiencia" rows="4" maxlength="1000"
                              placeholder="Descreva suas experiências profissionais anteriores, projetos desenvolvidos, estágios, etc."></textarea>
                    <div class="form-text">Opcional - Máximo de 1000 caracteres</div>
                </div>

                <div class="mb-3">
                    <label for="habilidades" class="form-label required-label">Habilidades Técnicas</label>
                    <textarea class="form-control" id="habilidades" name="habilidades" rows="3" maxlength="500" required
                              placeholder="Ex: PHP, Laravel, JavaScript, HTML, CSS, MySQL, Git"></textarea>
                    <div class="form-text">Máximo de 500 caracteres</div>
                </div>

                <div class="mb-4">
                    <label for="portfolio" class="form-label">Portfolio/GitHub</label>
                    <input type="url" class="form-control" id="portfolio" name="portfolio"
                           placeholder="https://github.com/seuusuario ou link do seu portfolio">
                    <div class="form-text">Opcional - Link para seu GitHub ou portfolio</div>
                </div>

                <!-- Seção: Motivação -->
                <h5 class="section-title">Carta de Motivação</h5>

                <div class="mb-3">
                    <label for="motivacao" class="form-label required-label">Por que você deseja esta vaga?</label>
                    <textarea class="form-control" id="motivacao" name="motivacao" rows="5" maxlength="1000" required
                              placeholder="Explique por que você tem interesse nesta oportunidade e como ela se alinha com seus objetivos profissionais"></textarea>
                    <div class="form-text">Máximo de 1000 caracteres</div>
                </div>

                <div class="mb-4">
                    <label for="disponibilidade" class="form-label required-label">Disponibilidade</label>
                    <textarea class="form-control" id="disponibilidade" name="disponibilidade" rows="2" maxlength="300"
                              required
                              placeholder="Informe sua disponibilidade de horários e dias da semana"></textarea>
                    <div class="form-text">Máximo de 300 caracteres</div>
                </div>

                <!-- Upload de Currículo -->
                <h5 class="section-title">Documentos</h5>

                <div class="mb-4">
                    <label for="curriculo" class="form-label">Currículo (PDF)</label>
                    <input type="file" class="form-control" id="curriculo" name="curriculo" accept=".pdf"
                           max-size="5MB">
                    <div class="form-text">Opcional - Máximo 5MB, apenas PDF</div>
                </div>

                <!-- Botões de Ação -->
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='/home'">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success" id="btn-candidatar">
                        <i class="bi bi-send-fill me-1"></i> Enviar Candidatura
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const formCandidatar = document.getElementById('formCandidatar');
    const alertArea = document.getElementById('alert-area');
    const btnCandidatar = document.getElementById('btn-candidatar');
    const vagaInfo = document.getElementById('vaga-info');

    // Obtém ID da vaga da URL
    const urlParams = new URLSearchParams(window.location.search);
    const vagaId = urlParams.get('vaga') || window.location.pathname.split('/').pop();

    // Carrega informações da vaga e do usuário ao carregar a página
    document.addEventListener('DOMContentLoaded', async () => {
        const token = localStorage.getItem('auth_token');

        if (!token) {
            window.location.href = '/login';
            return;
        }

        // Carrega dados da vaga
        try {
            const response = await fetch(`/api/v1/oportunidades/${vagaId}`, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                }
            });

            if (response.ok) {
                const result = await response.json();
                const vaga = result.data;

                vagaInfo.innerHTML = `
                    <h6 class="text-success mb-3">${vaga.titulo}</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Empresa:</strong> ${vaga.empresa || vaga.user?.name || 'Não informado'}</p>
                            <p><strong>Tipo:</strong> ${vaga.tipo_oportunidade?.nome || 'Não informado'}</p>
                            <p><strong>Modalidade:</strong> ${vaga.modalidade_texto || 'Não informado'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Localidade:</strong> ${vaga.localidade || 'Não informado'}</p>
                            <p><strong>Remuneração:</strong> ${vaga.remuneracao ? 'R$ ' + parseFloat(vaga.remuneracao).toFixed(2) : 'A combinar'}</p>
                            <p><strong>Vagas:</strong> ${vaga.vagas || 1}</p>
                        </div>
                    </div>
                `;
            } else {
                vagaInfo.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Não foi possível carregar as informações da vaga.
                    </div>
                `;
            }
        } catch (error) {
            console.error('Erro ao carregar vaga:', error);
        }

        // Pré-preenche dados do usuário se disponível
        try {
            const userResponse = await fetch('/api/v1/usuario/perfil', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                }
            });

            if (userResponse.ok) {
                const userData = await userResponse.json();
                const user = userData.data;

                if (user.name) document.getElementById('nome').value = user.name;
                if (user.email) document.getElementById('email').value = user.email;
            }
        } catch (error) {
            console.error('Erro ao carregar dados do usuário:', error);
        }
    });

    // Submissão do formulário
    formCandidatar.addEventListener('submit', async function (e) {
        e.preventDefault();

        // UI de carregamento
        btnCandidatar.disabled = true;
        btnCandidatar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Enviando...';
        alertArea.innerHTML = '';

        const token = localStorage.getItem('auth_token');

        if (!token) {
            window.location.href = '/login';
            return;
        }

        const formData = new FormData(formCandidatar);

        // Adiciona ID da vaga
        formData.append('oportunidade_id', vagaId);

        try {
            const response = await fetch('/api/v1/candidaturas', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                // Sucesso!
                alertArea.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Sucesso!</strong> ${result.message || 'Candidatura enviada com sucesso!'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;

                // Limpa o formulário
                formCandidatar.reset();

                // Redireciona após 3 segundos
                setTimeout(() => {
                    window.location.href = '/home';
                }, 3000);

            } else {
                // Erro
                let errorMsg = result.message || 'Erro ao enviar candidatura.';

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
                window.scrollTo({top: 0, behavior: 'smooth'});
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
            btnCandidatar.disabled = false;
            btnCandidatar.innerHTML = '<i class="bi bi-send-fill me-1"></i> Enviar Candidatura';
        }
    });
</script>

</body>

</html>

