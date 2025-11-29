<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - LinkedIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5;
        }

        .navbar-brand {
            font-weight: bold;
            color: #198754 !important;
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            background-color: #198754;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 2rem;
        }

        .form-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
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

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/home"><i class="bi bi-briefcase-fill me-2"></i>LinkedIF</a>

        <div class="d-flex align-items-center">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark"
                   id="userMenu" data-bs-toggle="dropdown">
                    <div class="avatar-circle me-2" style="width: 40px; height: 40px; font-size: 1.2rem;"
                         id="user-initials">U
                    </div>
                    <span class="fw-bold d-none d-md-block" id="user-name">Carregando...</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item active" href="/perfil">
                            <i class="bi bi-person me-2"></i>Meu Perfil
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <button class="dropdown-item text-danger" id="btn-logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Sair
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4 mb-5">
    <div class="row g-4">

        <!-- COLUNA ESQUERDA: RESUMO PERFIL -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3 form-card">
                <div class="card-body">
                    <div class="avatar-circle mx-auto mb-3" id="sidebar-initials">U</div>
                    <h5 class="card-title mb-1" id="sidebar-name">Usuário</h5>
                    <p class="text-muted small mb-3" id="sidebar-role">Perfil</p>

                    <div class="d-grid gap-2 mb-3">
                        <button type="button" class="btn btn-outline-success btn-sm" id="btn-scroll-form">
                            <i class="bi bi-pencil-square me-1"></i> Editar dados
                        </button>
                    </div>

                    <hr>

                    <div class="text-start small">
                        <p class="mb-1">
                            <i class="bi bi-envelope me-2 text-muted"></i>
                            <span id="info-email">-</span>
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-telephone me-2 text-muted"></i>
                            <span id="info-telefone">-</span>
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-mortarboard me-2 text-muted"></i>
                            <span id="info-curso">-</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3 form-card">
                <div class="card-body">
                    <h6 class="text-secondary mb-2">
                        <i class="bi bi-info-circle me-2"></i>Sobre
                    </h6>
                    <p class="small text-muted mb-0" id="info-bio">
                        Edite seu perfil para adicionar uma breve descrição sobre você, suas áreas de interesse
                        e links importantes.
                    </p>
                </div>
            </div>
        </div>

        <!-- COLUNA DIREITA: FORMULÁRIO -->
        <div class="col-md-8">
            <div id="alert-area"></div>

            <div class="form-card p-4">
                <h5 class="section-title">Informações do Perfil</h5>

                <form id="formPerfil">
    <div class="row mb-3">
        <div class="col-md-8">
            <label for="nome" class="form-label required-label">Nome completo / Razão social</label>
            <input type="text" class="form-control" id="nome" name="nome"
                   placeholder="Seu nome completo ou razão social" required>
        </div>
        <div class="col-md-4">
            <label for="tipo_perfil" class="form-label">Tipo de perfil</label>
            <input type="text" class="form-control" id="tipo_perfil" name="tipo_perfil" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="email" class="form-label required-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email"
                   placeholder="seu.email@exemplo.com" required>
        </div>
        <div class="col-md-6">
            <label for="telefone" class="form-label required-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone"
                   placeholder="(38) 99999-9999" required>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="whatsapp" name="whatsapp" value="1">
                <label class="form-check-label" for="whatsapp">
                    Este número é WhatsApp?
                </label>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="nascimento" class="form-label required-label">
                Data de Nascimento (ou Fundação)
            </label>
            <input type="date" class="form-control" id="nascimento" name="nascimento" required>
        </div>
        <div class="col-md-6">
            <label for="nome_usuario" class="form-label required-label">
                Nome de usuário (login)
            </label>
            <input type="text" class="form-control" id="nome_usuario" name="nome_usuario"
                   placeholder="seu_usuario" required>
        </div>
    </div>

    <!-- Campos específicos por tipo de perfil -->
    <div id="campos-aluno" class="mb-3" style="display: none;">
        <h6 class="text-secondary mb-2">🎓 Dados acadêmicos (Aluno)</h6>
        <div class="form-group">
            <label for="curso" class="form-label">Curso</label>
            <input type="text" class="form-control" id="curso" name="curso"
                   placeholder="Ex: Ciência da Computação">
        </div>
    </div>

    <div id="campos-empresa" class="mb-3" style="display: none;">
        <h6 class="text-secondary mb-2">🏢 Dados empresariais</h6>
        <div class="mb-2">
            <label for="cnpj" class="form-label">CNPJ</label>
            <input type="text" class="form-control" id="cnpj" name="cnpj"
                   placeholder="Apenas números (14 dígitos)">
        </div>
        <div class="mb-2">
            <label for="descricao" class="form-label">Descrição da empresa</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3"
                      placeholder="Fale um pouco sobre a empresa..."></textarea>
        </div>
    </div>

    <div id="campos-professor" class="mb-3" style="display: none;">
        <h6 class="text-secondary mb-2">📚 Dados acadêmicos (Professor)</h6>
        <p class="text-muted small mb-0">
            Os dados gerais já são suficientes para professores. Preencha apenas se desejar complementar.
        </p>
    </div>

    <h6 class="section-title mt-4">Presença digital e interesses</h6>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="linkedin" class="form-label">LinkedIn</label>
            <input type="url" class="form-control" id="linkedin" name="linkedin"
                   placeholder="https://www.linkedin.com/in/seu-usuario">
        </div>
        <div class="col-md-6">
            <label for="github" class="form-label">GitHub / Portfólio</label>
            <input type="url" class="form-control" id="github" name="github"
                   placeholder="https://github.com/seu-usuario">
        </div>
    </div>

    <div class="mb-3">
        <label for="areas_interesse" class="form-label">Áreas de Interesse</label>
        <input type="text" class="form-control" id="areas_interesse" name="areas_interesse"
               placeholder="Ex: Desenvolvimento Web, IA, Extensão, Pesquisa em Educação">
        <div class="form-text">Separe por vírgulas, se desejar.</div>
    </div>

    <div class="mb-4">
        <label for="bio" class="form-label">Sobre você / Sobre a empresa</label>
        <textarea class="form-control" id="bio" name="bio" rows="3"
                  placeholder="Descreva brevemente sua experiência, interesses ou atuação."></textarea>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="/home" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Voltar ao Feed
        </a>
        <button type="submit" class="btn btn-success" id="btn-salvar">
            <i class="bi bi-check2-circle me-1"></i> Salvar alterações
        </button>
    </div>
</form>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const alertArea = document.getElementById('alert-area');
    const btnSalvar = document.getElementById('btn-salvar');
    const formPerfil = document.getElementById('formPerfil');

    const divAluno = document.getElementById('campos-aluno');
    const divEmpresa = document.getElementById('campos-empresa');
    const divProfessor = document.getElementById('campos-professor');

    // Scroll para o formulário ao clicar no botão da sidebar
    document.getElementById('btn-scroll-form').addEventListener('click', () => {
        formPerfil.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    document.addEventListener('DOMContentLoaded', async () => {
        const token = localStorage.getItem('auth_token');

        if (!token) {
            window.location.href = '/login';
            return;
        }

        // 1) Preenche rápido com user_data do localStorage (se existir)
        const userDataRaw = localStorage.getItem('user_data');
        if (userDataRaw) {
            try {
                const userLocal = JSON.parse(userDataRaw);
                if (userLocal && typeof userLocal === 'object') {
                    preencherPerfil(userLocal);
                }
            } catch (e) {
                console.warn('Não foi possível parsear user_data do localStorage:', e);
            }
        }

        // 2) Busca a versão mais atual na API
        try {
            const response = await fetch('/api/v1/perfil', {
                headers: {
                    'Authorization': token, // se o back esperar "Bearer", trocar para `Bearer ${token}`
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                console.error('Sessão inválida ou erro ao buscar perfil');
                logout();
                return;
            }

            const json = await response.json();
            const user = json.data;

            preencherPerfil(user);
        } catch (error) {
            console.error('Erro ao carregar perfil:', error);
            alertArea.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Erro ao carregar informações do perfil.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }
    });

    function preencherPerfil(user) {
        const nome = user.nome || user.nome_usuario || '';
        const email = user.email || '';
        const telefone = user.telefone || '';
        const nascimento = user.nascimento || '';
        const whatsapp = !!user.whatsapp;
        const curso = user.curso || '';
        const cnpj = user.cnpj || '';
        const descricaoEmpresa = user.descricao || '';
        const bio = user.bio || '';
        const linkedin = user.linkedin || '';
        const github = user.github || '';
        const areasInteresse = user.areas_interesse || '';
        const loginUsuario = user.nome_usuario || '';
        const tipoPerfilNum = user.tipo_perfil; // no /perfil você disse que vinha 3,4,5

        const inicial = nome ? nome.charAt(0).toUpperCase() : 'U';

        const perfilTexto =
            tipoPerfilNum === 3 || user.tipo_perfil === 'ALUNO' ? 'Aluno' :
            tipoPerfilNum === 4 || user.tipo_perfil === 'EMPRESA' ? 'Empresa' :
            tipoPerfilNum === 5 || user.tipo_perfil === 'PROFESSOR' ? 'Professor' :
            'Usuário';

        // Navbar
        document.getElementById('user-name').innerText = nome || 'Usuário';
        document.getElementById('user-initials').innerText = inicial;

        // Sidebar
        document.getElementById('sidebar-name').innerText = nome || 'Usuário';
        document.getElementById('sidebar-role').innerText = perfilTexto;
        document.getElementById('sidebar-initials').innerText = inicial;

        document.getElementById('info-email').innerText = email || '-';
        document.getElementById('info-telefone').innerText = telefone || '-';
        document.getElementById('info-curso').innerText = curso || '-';
        document.getElementById('info-bio').innerText = bio || 'Adicione uma breve descrição sobre você.';

        // Mostrar / esconder blocos específicos
        divAluno.style.display = 'none';
        divEmpresa.style.display = 'none';
        divProfessor.style.display = 'none';

        if (perfilTexto === 'Aluno') {
            divAluno.style.display = 'block';
        } else if (perfilTexto === 'Empresa') {
            divEmpresa.style.display = 'block';
        } else if (perfilTexto === 'Professor') {
            divProfessor.style.display = 'block';
        }

        // Form
        document.getElementById('nome').value = nome;
        document.getElementById('tipo_perfil').value = perfilTexto;
        document.getElementById('email').value = email;
        document.getElementById('telefone').value = telefone;
        document.getElementById('nascimento').value = nascimento ? nascimento.substring(0, 10) : '';
        document.getElementById('whatsapp').checked = whatsapp;

        document.getElementById('nome_usuario').value = loginUsuario;
        document.getElementById('curso').value = curso;
        document.getElementById('cnpj').value = cnpj;
        document.getElementById('descricao').value = descricaoEmpresa;
        document.getElementById('bio').value = bio;
        document.getElementById('linkedin').value = linkedin;
        document.getElementById('github').value = github;
        document.getElementById('areas_interesse').value = areasInteresse;
    }

    formPerfil.addEventListener('submit', async (e) => {
        e.preventDefault();
        alertArea.innerHTML = '';

        const token = localStorage.getItem('auth_token');

        if (!token) {
            window.location.href = '/login';
            return;
        }

        btnSalvar.disabled = true;
        btnSalvar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Salvando...';

        const formData = new FormData(formPerfil);
        const data = Object.fromEntries(formData.entries());

        // checkbox whatsapp → boolean
        data.whatsapp = document.getElementById('whatsapp').checked ? true : false;

        try {
            const response = await fetch('/api/v1/perfil', {
                method: 'PUT', // se o back usar PATCH/POST, ajustar aqui
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': token
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                alertArea.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Perfil atualizado!</strong> ${result.message || ''}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;

                if (result.data) {
                    localStorage.setItem('user_data', JSON.stringify(result.data));
                    preencherPerfil(result.data);
                }
            } else {
                let msg = result.message || 'Erro ao atualizar o perfil.';

                if (result.errors) {
                    msg += '<ul class="mb-0 mt-2">';
                    Object.values(result.errors).forEach(errors => {
                        errors.forEach(error => {
                            msg += `<li>${error}</li>`;
                        });
                    });
                    msg += '</ul>';
                }

                alertArea.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        ${msg}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Erro ao salvar perfil:', error);
            alertArea.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Erro ao conectar ao servidor.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        } finally {
            btnSalvar.disabled = false;
            btnSalvar.innerHTML = '<i class="bi bi-check2-circle me-1"></i> Salvar alterações';
        }
    });

    // Logout igual ao dashboard
    document.getElementById('btn-logout').addEventListener('click', logout);

    function logout() {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_data');
        window.location.href = '/login';
    }
</script>



</body>
</html>
