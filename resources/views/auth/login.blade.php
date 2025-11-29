<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LinkedIF</title>
    @vite(['resources/css/auth.css'])
</head>

<body>
    <div class="login-container">
        <div class="login-content">

            <div class="login-header">
                <div class="logo-section">
                    <div class="logo-placeholder">IFNMG</div>
                    <h1>LinkedIF</h1>
                    <p class="tagline">Conectando talentos e oportunidades</p>
                </div>
            </div>

            <div class="login-card">

                <div id="alert-area"></div>

                <form id="formLogin" class="login-form">

                    <div class="form-group">
                        <label for="nome_usuario">Nome de Usuário</label>
                        <input
                            type="text"
                            id="nome_usuario"
                            name="nome_usuario"
                            placeholder="Digite seu nome de usuário"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input
                            type="password"
                            id="senha"
                            name="senha"
                            placeholder="Digite sua senha"
                            required
                        />
                    </div>

                    <button type="submit" class="btn-submit" id="btn-submit">
                        Entrar
                    </button>

                    <div class="forgot-password">
                        <a href="#">Esqueceu sua senha?</a>
                    </div>
                </form>

                <div class="divider">
                    <span>ou</span>
                </div>

                <div class="toggle-mode">
                    <p>
                        Não tem uma conta?
                        <a href="/cadastro" class="link-button">Cadastre-se</a>
                    </p>
                </div>
            </div>

            <footer class="login-footer">
                <p>© 2025 IFNMG - Instituto Federal do Norte de Minas Gerais</p>
                <p>Campus Montes Claros</p>
            </footer>

        </div>
    </div>

    <script>
        const form = document.getElementById('formLogin');
        const alertArea = document.getElementById('alert-area');
        const btnSubmit = document.getElementById('btn-submit');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            btnSubmit.disabled = true;
            const originalText = btnSubmit.textContent;
            btnSubmit.innerHTML = '<span class="spinner"></span> Entrando...';
            alertArea.innerHTML = '';

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {
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
                    const tokenCompleto = 'Bearer ' + result.data.token;
                    localStorage.setItem('auth_token', tokenCompleto);

                    alertArea.innerHTML = '<div class="success-message">Login bem-sucedido! Redirecionando...</div>';

                    setTimeout(() => {
                        window.location.href = '/home';
                    }, 1000);

                } else {
                    let errorMsg = result.message || 'Erro desconhecido.';
                    alertArea.innerHTML = `<div class="error-message">${errorMsg}</div>`;
                }

            } catch (error) {
                console.error('Erro de rede:', error);
                alertArea.innerHTML = '<div class="error-message"><strong>Erro de Conexão:</strong> Servidor offline ou erro de rede.</div>';
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.textContent = originalText;
            }
        });
    </script>

</body>

</html>
