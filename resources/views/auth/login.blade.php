<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LinkedIF</title>
    <!-- Bootstrap 5 CSS e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            /* Cor de fundo verde do seu Header */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <div class="card login-card border-0">
        <div class="card-body">
            <div class="text-center mb-4">
                <h3 class="fw-bold mb-1" style="color: #198754;">LinkedIF</h3>
                <p class="text-muted small">Faça login para continuar</p>
            </div>

            <div id="alert-area"></div>

            <form id="formLogin">

                <div class="mb-3">
                    <label for="nome_usuario" class="form-label">Nome de Usuário</label>
                    <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" required>
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-success btn-lg fw-bold" id="btn-submit">Entrar</button>
                </div>

                <div class="text-center mt-3">
                    <a href="/cadastro" class="text-secondary small">Não tem uma conta? **Cadastre-se**</a>
                </div>
            </form>

        </div>
    </div>

    <!-- JAVASCRIPT PARA LÓGICA DE LOGIN -->
    <script>
        const form = document.getElementById('formLogin');
        const alertArea = document.getElementById('alert-area');
        const btnSubmit = document.getElementById('btn-submit');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            // UI de carregamento
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Entrando...';
            alertArea.innerHTML = '';

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {
                // Chamada para sua API de login
                const response = await fetch('/api/v1/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    // SUCESSO!
                    // Salva o token no Local Storage (MUITO IMPORTANTE)
                    localStorage.setItem('auth_token', result.data.token);

                    alertArea.innerHTML = `<div class="alert alert-success">Login bem-sucedido! Redirecionando...</div>`;

                    // Redireciona para a home
                    setTimeout(() => {
                        window.location.href = '/home';
                    }, 1000);

                } else {
                    // ERRO (Credenciais inválidas, conta inativa, etc.)
                    let errorMsg = result.message || 'Erro desconhecido.';
                    alertArea.innerHTML = `<div class="alert alert-danger">${errorMsg}</div>`;
                }

            } catch (error) {
                console.error('Erro de rede:', error);
                alertArea.innerHTML = `<div class="alert alert-danger"><strong>Erro de Conexão:</strong> Servidor offline ou erro de rede.</div>`;
            } finally {
                // Restaura o botão
                btnSubmit.disabled = false;
                btnSubmit.innerText = 'Entrar';
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>