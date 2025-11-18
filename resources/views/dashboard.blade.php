<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Meu Perfil</a></li>
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
                        <a href="#" class="list-group-item list-group-item-action active bg-success border-success"><i class="bi bi-house-door me-2"></i> Feed</a>
                        <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-bookmark me-2"></i> Salvos</a>
                        <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-bell me-2"></i> Notificações</a>
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

                <div class="row g-3">

                    <div class="col-md-12">
                        <div class="card card-opportunity border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title text-primary mb-1">Estágio em Desenvolvimento Web</h5>
                                        <h6 class="card-subtitle mb-2 text-muted"><i class="bi bi-building me-1"></i> TechSolutions Montes Claros</h6>
                                    </div>
                                    <span class="badge bg-light text-dark border">Estágio</span>
                                </div>
                                <p class="card-text mt-2 text-secondary">Procuramos alunos de Ciência da Computação ou áreas afins para atuar com PHP, Laravel e React.</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted"><i class="bi bi-clock me-1"></i> Há 2 horas</small>
                                    <button class="btn btn-sm btn-outline-primary">Ver Detalhes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card card-opportunity border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title text-primary mb-1">Bolsista de Iniciação Científica</h5>
                                        <h6 class="card-subtitle mb-2 text-muted"><i class="bi bi-mortarboard me-1"></i> IFNMG - Laboratório de IA</h6>
                                    </div>
                                    <span class="badge bg-light text-dark border">Pesquisa</span>
                                </div>
                                <p class="card-text mt-2 text-secondary">Vaga para projeto de pesquisa em Inteligência Artificial aplicada à saúde. Requisito: Python básico.</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted"><i class="bi bi-clock me-1"></i> Ontem</small>
                                    <button class="btn btn-sm btn-outline-primary">Ver Detalhes</button>
                                </div>
                            </div>
                        </div>
                    </div>

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
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const json = await response.json();
                    const user = json.data;

                    // Atualiza a UI com os dados reais
                    const nome = user.nome_usuario;
                    const perfil = user.tipo_perfil === 3 ? 'Aluno' : (user.tipo_perfil === 4 ? 'Empresa' : 'Professor');
                    const inicial = nome.charAt(0).toUpperCase();

                    document.getElementById('user-name').innerText = nome;
                    document.getElementById('user-initials').innerText = inicial;

                    document.getElementById('sidebar-name').innerText = nome;
                    document.getElementById('sidebar-role').innerText = perfil;
                    document.getElementById('sidebar-initials').innerText = inicial;
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

</html>