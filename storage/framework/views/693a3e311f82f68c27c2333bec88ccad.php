<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Dashboard - LinkedIF</title>
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

        .card-opportunity {
            transition: transform 0.2s;
            cursor: pointer;
        }

        .card-opportunity:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            background-color: #198754;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-briefcase-fill me-2"></i>LinkedIF</a>

            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" id="userMenu" data-bs-toggle="dropdown">
                        <div class="avatar-circle me-2" id="user-initials">U</div>
                        <span class="fw-bold d-none d-md-block" id="user-name">Carregando...</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/perfil"><i class="bi bi-person me-2"></i>Meu Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><button class="dropdown-item text-danger" id="btn-logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm text-center p-3">
                    <div class="card-body">
                        <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;" id="sidebar-initials">U</div>
                        <h5 class="card-title mb-1" id="sidebar-name">Usuário</h5>
                        <p class="text-muted small mb-3" id="sidebar-role">Perfil</p>

                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-square me-1"></i> Editar Perfil</button>
                        </div>

                        <hr>

                        <div class="row text-center">
                            <div class="col-6">
                                <h6 class="fw-bold mb-0">12</h6>
                                <small class="text-muted">Vagas</small>
                            </div>
                            <div class="col-6">
                                <h6 class="fw-bold mb-0">5</h6>
                                <small class="text-muted">Projetos</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-3">
                    <div class="list-group list-group-flush">
                        <a href="/home" class="list-group-item list-group-item-action active bg-success border-success"><i class="bi bi-house-door me-2"></i> Feed</a>
                        <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-bookmark me-2"></i> Salvos</a>
                        <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-bell me-2"></i> Notificações</a>
                    </div>
                </div>

                <!-- Botão para Publicar Oportunidade (apenas para Editores) -->
                <div class="card border-0 shadow-sm mt-3" id="publicar-oportunidade-card" style="display: none;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-success mb-3"><i class="bi bi-megaphone-fill me-2"></i>Para Empresas e Professores</h6>
                        <a href="/oportunidades/publicar" class="btn btn-success w-100">
                            <i class="bi bi-plus-circle me-1"></i> Publicar Oportunidade
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">

                <div class="alert alert-success border-0 shadow-sm mb-4">
                    <h4 class="alert-heading">Bem-vindo ao LinkedIF! 🚀</h4>
                    <p class="mb-0">Conecte-se com oportunidades de estágio, emprego e projetos no IFNMG Montes Claros.</p>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" placeholder="Pesquisar vagas, empresas ou projetos...">
                            <button class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                </div>

                <h5 class="mb-3 text-secondary">Oportunidades Recentes</h5>

                <!-- Loading -->
                <div id="loading-oportunidades" class="text-center py-5">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-2 text-muted">Carregando oportunidades...</p>
                </div>

                <!-- Sem oportunidades -->
                <div id="sem-oportunidades" class="alert alert-info border-0 shadow-sm" style="display: none;">
                    <i class="bi bi-info-circle me-2"></i>
                    Nenhuma oportunidade disponível no momento.
                </div>

                <!-- Container das oportunidades -->
                <div id="oportunidades-container" class="row g-3" style="display: none;">
                    <!-- As oportunidades serão inseridas aqui via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes da Oportunidade -->
    <div class="modal fade" id="modalDetalhes" tabindex="-1" aria-labelledby="modalDetalhesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalDetalhesLabel">
                        <i class="bi bi-briefcase-fill me-2"></i>Detalhes da Oportunidade
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body-content">
                    <!-- Alerta de Perfil Incompleto -->
                    <div class="alert alert-warning border-0 shadow-sm" id="alerta-perfil-incompleto" style="display: none;">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-warning"></i>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading mb-2">Perfil Incompleto</h5>
                                <p class="mb-2" id="mensagem-perfil"></p>
                                <div class="mb-3">
                                    <strong>Completude atual: <span id="completude-perfil" class="text-warning"></span></strong>
                                </div>
                                <div class="mb-3">
                                    <strong>Campos faltantes:</strong>
                                    <ul id="campos-faltantes-lista" class="mb-0 mt-2"></ul>
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <a href="/perfil" class="btn btn-warning">
                                        <i class="bi bi-pencil-square me-2"></i>Completar Meu Perfil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loading -->
                    <div class="text-center py-5" id="modal-loading">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                    </div>

                    <!-- Conteúdo será inserido aqui -->
                    <div id="modal-detalhes-content" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" id="btn-candidatar" style="display: none;">
                        <i class="bi bi-send-fill me-1"></i>Candidatar-se
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            // 1. Recupera o Token e Dados do LocalStorage (salvos no login)
            const token = localStorage.getItem('auth_token');

            if (!token) {
                // Se não tiver token, manda pro login
                window.location.href = '/login';
                return;
            }

            // 2. Busca os dados do perfil na API
            try {
                const response = await fetch('/api/v1/perfil', {
                    headers: {
                        'Authorization': token, // <--- AQUI! Envia a string completa (Bearer ...)
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const json = await response.json();
                    const user = json.data;

                    // Atualiza a UI com os dados reais
                    const nome = user.nome_usuario;
                    const tipoPerfil = user.tipo_perfil;
                    const perfil = tipoPerfil === 3 ? 'Aluno' : (tipoPerfil === 4 ? 'Empresa' : 'Professor');
                    const inicial = nome.charAt(0).toUpperCase();

                    document.getElementById('user-name').innerText = nome;
                    document.getElementById('user-initials').innerText = inicial;

                    document.getElementById('sidebar-name').innerText = nome;
                    document.getElementById('sidebar-role').innerText = perfil;
                    document.getElementById('sidebar-initials').innerText = inicial;

                    // Mostra o botão de publicar oportunidade apenas para Empresas (4) e Professores (5)
                    if (tipoPerfil === 4 || tipoPerfil === 5) {
                        document.getElementById('publicar-oportunidade-card').style.display = 'block';
                    }

                    // Carrega as oportunidades
                    carregarOportunidades();
                } else {
                    // Token expirado ou inválido (e não 200)
                    console.error('Sessão expirada');
                    logout(); // Chama logout, que agora redireciona para /login
                }
            } catch (error) {
                console.error('Erro ao buscar perfil:', error);
                logout(); // Chama logout, que agora redireciona para /login
            }
        });

        // Função para carregar oportunidades
        async function carregarOportunidades() {
            try {
                const response = await fetch('/api/v1/oportunidades', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                console.log('Response status:', response.status);
                
                if (response.ok) {
                    const result = await response.json();
                    console.log('Resultado da API:', result);
                    const oportunidades = result.data;

                    // Esconde o loading
                    document.getElementById('loading-oportunidades').style.display = 'none';

                    if (oportunidades.length === 0) {
                        // Mostra mensagem de sem oportunidades
                        document.getElementById('sem-oportunidades').style.display = 'block';
                    } else {
                        // Mostra o container
                        document.getElementById('oportunidades-container').style.display = 'block';

                        // Renderiza as oportunidades
                        const container = document.getElementById('oportunidades-container');
                        container.innerHTML = ''; // Limpa o container

                        oportunidades.forEach(oportunidade => {
                            const card = criarCardOportunidade(oportunidade);
                            container.innerHTML += card;
                        });
                    }
                } else {
                    console.error('Erro ao carregar oportunidades, status:', response.status);
                    const errorText = await response.text();
                    console.error('Resposta do servidor:', errorText);
                    document.getElementById('loading-oportunidades').style.display = 'none';
                    document.getElementById('sem-oportunidades').style.display = 'block';
                }
            } catch (error) {
                console.error('Erro ao buscar oportunidades:', error);
                document.getElementById('loading-oportunidades').style.display = 'none';
                document.getElementById('sem-oportunidades').innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i> Erro ao carregar oportunidades.';
                document.getElementById('sem-oportunidades').style.display = 'block';
            }
        }

        // Função para criar card de oportunidade
        function criarCardOportunidade(oportunidade) {
            const remuneracao = oportunidade.remuneracao
                ? `<small class="text-success"><i class="bi bi-currency-dollar me-1"></i>R$ ${parseFloat(oportunidade.remuneracao).toFixed(2)}</small>`
                : '';

            return `
                <div class="col-md-12">
                    <div class="card card-opportunity border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="card-title text-primary mb-1">${oportunidade.titulo}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        <i class="bi bi-building me-1"></i> ${oportunidade.editor.nome}
                                    </h6>
                                </div>
                                <span class="badge bg-light text-dark border">${oportunidade.tipo}</span>
                            </div>
                            <p class="card-text mt-2 text-secondary">${oportunidade.descricao}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <small class="text-muted"><i class="bi bi-clock me-1"></i> ${oportunidade.publicado_em}</small>
                                    <small class="text-muted ms-3"><i class="bi bi-geo-alt me-1"></i> ${oportunidade.modalidade}</small>
                                    ${remuneracao ? '<span class="ms-3">' + remuneracao + '</span>' : ''}
                                </div>
                                <button class="btn btn-sm btn-outline-primary" onclick="verDetalhes(${oportunidade.id})">
                                    Ver Detalhes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Função para ver detalhes
        async function verDetalhes(id) {
            // Abre o modal
            const modal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
            modal.show();

            // Esconde o alerta de perfil incompleto e mostra loading
            document.getElementById('alerta-perfil-incompleto').style.display = 'none';
            document.getElementById('modal-loading').style.display = 'block';
            document.getElementById('modal-detalhes-content').style.display = 'none';
            document.getElementById('btn-candidatar').style.display = 'none';

            try {
                const response = await fetch(`/api/v1/oportunidades/${id}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                console.log('Response status:', response.status);

                if (response.ok) {
                    const result = await response.json();
                    console.log('Dados recebidos:', result);
                    const oportunidade = result.data;

                    // Esconde loading
                    document.getElementById('modal-loading').style.display = 'none';

                    // Renderiza os detalhes
                    const detalhesHTML = criarDetalhesOportunidade(oportunidade);
                    document.getElementById('modal-detalhes-content').innerHTML = detalhesHTML;
                    document.getElementById('modal-detalhes-content').style.display = 'block';

                    // Mostra botão de candidatura
                    document.getElementById('btn-candidatar').style.display = 'inline-block';
                    document.getElementById('btn-candidatar').onclick = () => candidatar(id);
                } else {
                    const errorText = await response.text();
                    console.error('Erro ao carregar detalhes. Status:', response.status, 'Resposta:', errorText);
                    document.getElementById('modal-loading').style.display = 'none';
                    document.getElementById('modal-detalhes-content').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Erro ao carregar detalhes da oportunidade. (Status: ${response.status})
                        </div>
                    `;
                    document.getElementById('modal-detalhes-content').style.display = 'block';
                }
            } catch (error) {
                console.error('Erro ao buscar detalhes:', error);
                document.getElementById('modal-loading').style.display = 'none';
                document.getElementById('modal-detalhes-content').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Erro ao conectar ao servidor: ${error.message}
                    </div>
                `;
                document.getElementById('modal-detalhes-content').style.display = 'block';
            }
        }

        // Função para criar HTML dos detalhes
        function criarDetalhesOportunidade(oportunidade) {
            const remuneracao = oportunidade.remuneracao
                ? `<p><strong><i class="bi bi-currency-dollar me-2 text-success"></i>Remuneração:</strong> R$ ${parseFloat(oportunidade.remuneracao).toFixed(2)}</p>`
                : '<p><strong><i class="bi bi-currency-dollar me-2 text-muted"></i>Remuneração:</strong> Não informada</p>';

            const horarios = oportunidade.horario_inicio && oportunidade.horario_termino
                ? `<p><strong><i class="bi bi-clock me-2 text-primary"></i>Horário:</strong> ${oportunidade.horario_inicio} às ${oportunidade.horario_termino}</p>`
                : '<p><strong><i class="bi bi-clock me-2 text-muted"></i>Horário:</strong> Flexível</p>';

            const escala = oportunidade.escala
                ? `<p><strong><i class="bi bi-calendar-week me-2 text-info"></i>Carga Horária:</strong> ${oportunidade.escala} horas/semana</p>`
                : '';

            const localidade = oportunidade.localidade
                ? `<p><strong><i class="bi bi-geo-alt me-2 text-danger"></i>Localidade:</strong> ${oportunidade.localidade}</p>`
                : '';

            const termino = oportunidade.termino
                ? `<p><strong><i class="bi bi-calendar-check me-2"></i>Data de Término:</strong> ${oportunidade.termino}</p>`
                : '<p><strong><i class="bi bi-calendar-check me-2"></i>Data de Término:</strong> Indeterminado</p>';

            let habilidadesHTML = '';
            if (oportunidade.habilidades && oportunidade.habilidades.length > 0) {
                const badges = oportunidade.habilidades.map(hab =>
                    `<span class="badge bg-primary me-1 mb-1">${hab.nome}</span>`
                ).join('');
                habilidadesHTML = `
                    <div class="mb-3">
                        <strong><i class="bi bi-stars me-2 text-warning"></i>Habilidades Desejadas:</strong>
                        <div class="mt-2">${badges}</div>
                    </div>
                `;
            }

            return `
                <div class="mb-3">
                    <h4 class="text-success">${oportunidade.titulo}</h4>
                    <p class="text-muted">
                        <i class="bi bi-building me-1"></i> ${oportunidade.editor.nome}
                        <span class="badge bg-light text-dark border ms-2">${oportunidade.tipo}</span>
                    </p>
                </div>

                <hr>

                <div class="mb-3">
                    <h6 class="text-secondary"><i class="bi bi-file-text me-2"></i>Descrição</h6>
                    <p>${oportunidade.descricao}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-secondary"><i class="bi bi-list-check me-2"></i>Requisitos</h6>
                    <p>${oportunidade.requisitos}</p>
                </div>

                ${oportunidade.beneficios ? `
                    <div class="mb-3">
                        <h6 class="text-secondary"><i class="bi bi-gift me-2"></i>Benefícios</h6>
                        <p>${oportunidade.beneficios}</p>
                    </div>
                ` : ''}

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong><i class="bi bi-people me-2 text-info"></i>Vagas:</strong> ${oportunidade.vagas}</p>
                        <p><strong><i class="bi bi-laptop me-2 text-primary"></i>Modalidade:</strong> ${oportunidade.modalidade}</p>
                        ${localidade}
                    </div>
                    <div class="col-md-6">
                        ${remuneracao}
                        ${horarios}
                        ${escala}
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong><i class="bi bi-calendar-plus me-2"></i>Data de Início:</strong> ${oportunidade.inicio}</p>
                        ${termino}
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="bi bi-code me-2 text-muted"></i>Código:</strong> ${oportunidade.codigo}</p>
                        <p><strong><i class="bi bi-clock-history me-2"></i>Publicado:</strong> ${oportunidade.publicado_em}</p>
                    </div>
                </div>

                ${habilidadesHTML}

                ${oportunidade.editor.descricao ? `
                    <hr>
                    <div class="mb-3">
                        <h6 class="text-secondary"><i class="bi bi-info-circle me-2"></i>Sobre o Ofertante</h6>
                        <p>${oportunidade.editor.descricao}</p>
                    </div>
                ` : ''}
            `;
        }

        // Função para candidatar
        async function candidatar(id) {
            // Desabilita o botão e mostra loading
            const btnCandidatar = document.getElementById('btn-candidatar');
            const textoOriginal = btnCandidatar.innerHTML;
            btnCandidatar.disabled = true;
            btnCandidatar.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Candidatando...';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                const token = localStorage.getItem('auth_token');
                
                const response = await fetch(`/oportunidades/${id}/candidatar`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Authorization': token ? `Bearer ${token}` : ''
                    },
                    credentials: 'same-origin' // Importante para enviar cookies de sessão
                });

                if (response.ok) {
                    // Fecha o modal
                    bootstrap.Modal.getInstance(document.getElementById('modalDetalhes')).hide();
                    
                    // Mostra mensagem de sucesso
                    alert('✅ Candidatura realizada com sucesso!\n\nEm breve você receberá um retorno.');
                    
                    // Recarrega as oportunidades
                    carregarOportunidades();
                } else {
                    const result = await response.json();
                    console.log('Erro na candidatura:', result); // Log para debug
                    
                    // Verifica se é erro de perfil incompleto
                    if (result.campos_faltantes && result.completude !== undefined) {
                        // Esconde o conteúdo da oportunidade e o botão de candidatar
                        document.getElementById('modal-detalhes-content').style.display = 'none';
                        btnCandidatar.style.display = 'none';
                        
                        // Preenche o alerta de perfil incompleto
                        document.getElementById('mensagem-perfil').textContent = result.message;
                        document.getElementById('completude-perfil').textContent = result.completude + '%';
                        
                        // Preenche a lista de campos faltantes
                        const listaFaltantes = document.getElementById('campos-faltantes-lista');
                        listaFaltantes.innerHTML = '';
                        result.campos_faltantes.forEach(campo => {
                            const li = document.createElement('li');
                            li.textContent = campo;
                            listaFaltantes.appendChild(li);
                        });
                        
                        // Mostra o alerta
                        document.getElementById('alerta-perfil-incompleto').style.display = 'block';
                    } else {
                        alert('❌ ' + (result.message || 'Erro ao realizar candidatura. Tente novamente.'));
                    }
                }
            } catch (error) {
                console.error('Erro ao candidatar:', error);
                alert('❌ Erro ao conectar ao servidor. Tente novamente.');
            } finally {
                // Restaura o botão
                btnCandidatar.disabled = false;
                btnCandidatar.innerHTML = textoOriginal;
            }
        }

        // Função de Logout
        document.getElementById('btn-logout').addEventListener('click', logout);

        function logout() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');

            // #################################################
            // ### CORREÇÃO APLICADA AQUI ###
            // Redireciona para a página de login
            // #################################################
            window.location.href = '/login';
        }
    </script>

</body>

</html><?php /**PATH /var/www/resources/views/dashboard.blade.php ENDPATH**/ ?>