<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro - LinkedIF</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
        
        .error.show {
            display: block;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }
        
        .success.show {
            display: block;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
        }
        
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
        
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎓 LinkedIF</h1>
        <p class="subtitle">Criar nova conta</p>
        
        <div id="successMessage" class="success"></div>
        
        <form id="registerForm">
            <div class="form-group">
                <label for="nome_usuario">Nome de usuário</label>
                <input type="text" id="nome_usuario" name="nome_usuario" required maxlength="20">
                <div id="nome_usuarioError" class="error"></div>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required minlength="6">
                <div id="senhaError" class="error"></div>
            </div>
            
            <button type="submit" id="submitBtn">Registrar</button>
        </form>
        
        <div class="login-link">
            Já tem uma conta? <a href="{{ route('login.form') }}">Fazer login</a>
        </div>
    </div>
    
    <script>
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const successMessage = document.getElementById('successMessage');
        
        // Limpar mensagens de erro
        function clearErrors() {
            document.querySelectorAll('.error').forEach(el => {
                el.classList.remove('show');
                el.textContent = '';
            });
            successMessage.classList.remove('show');
            successMessage.textContent = '';
        }
        
        // Mostrar erros
        function showErrors(errors) {
            for (const [field, messages] of Object.entries(errors)) {
                const errorEl = document.getElementById(`${field}Error`);
                if (errorEl) {
                    errorEl.textContent = messages[0];
                    errorEl.classList.add('show');
                }
            }
        }
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearErrors();
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Registrando...';
            
            const formData = {
                nome_usuario: document.getElementById('nome_usuario').value,
                senha: document.getElementById('senha').value,
            };
            
            try {
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 30000); // 30 segundos timeout
                
                const response = await fetch('/api/auth/registro', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData),
                    signal: controller.signal
                });
                
                clearTimeout(timeoutId);
                const data = await response.json();
                
                if (response.ok) {
                    successMessage.textContent = data.message || 'Registro realizado com sucesso!';
                    successMessage.classList.add('show');
                    form.reset();
                    
                    // Redirecionar para login após 2 segundos
                    setTimeout(() => {
                        window.location.href = '{{ route("login.form") }}';
                    }, 2000);
                } else {
                    if (data.errors) {
                        showErrors(data.errors);
                    } else {
                        alert(data.message || 'Erro ao realizar registro');
                    }
                }
            } catch (error) {
                if (error.name === 'AbortError') {
                    alert('Requisição demorou muito. Verifique sua conexão ou tente novamente.');
                } else {
                    alert('Erro de conexão. Tente novamente.');
                }
                console.error('Erro:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Registrar';
            }
        });
    </script>
</body>
</html>
