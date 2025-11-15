<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - LinkedIF</title>
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
            max-width: 400px;
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
        
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
            font-size: 14px;
        }
        
        .error-message.show {
            display: block;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
            font-size: 14px;
        }
        
        .success-message.show {
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
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
        
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .user-info {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            display: none;
        }
        
        .user-info.show {
            display: block;
        }
        
        .user-info h3 {
            margin-bottom: 10px;
            color: #333;
            font-size: 16px;
        }
        
        .user-info p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        
        .logout-btn {
            margin-top: 10px;
            background: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎓 LinkedIF</h1>
        <p class="subtitle">Faça login para continuar</p>
        
        <div id="errorMessage" class="error-message"></div>
        <div id="successMessage" class="success-message"></div>
        
        <form id="loginForm">
            <div class="form-group">
                <label for="nome_usuario">Nome de usuário</label>
                <input type="text" id="nome_usuario" name="nome_usuario" required>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            
            <button type="submit" id="submitBtn">Entrar</button>
        </form>
        
        <div class="register-link">
            Não tem uma conta? <a href="{{ route('register.form') }}">Registrar-se</a>
        </div>
        
        <div id="userInfo" class="user-info">
            <h3>✅ Login realizado com sucesso!</h3>
            <p><strong>Usuário:</strong> <span id="userName"></span></p>
            <p><strong>Email:</strong> <span id="userEmail"></span></p>
            <p><strong>Token:</strong> <span id="userToken" style="font-size: 11px; word-break: break-all;"></span></p>
            <button class="logout-btn" onclick="logout()">Sair</button>
        </div>
    </div>
    
    <script>
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const errorMessage = document.getElementById('errorMessage');
        const successMessage = document.getElementById('successMessage');
        const userInfo = document.getElementById('userInfo');
        
        // Verificar se já está logado
        const token = localStorage.getItem('auth_token');
        if (token) {
            loadUserProfile(token);
        }
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            errorMessage.classList.remove('show');
            successMessage.classList.remove('show');
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Entrando...';
            
            const formData = {
                nome_usuario: document.getElementById('nome_usuario').value,
                senha: document.getElementById('senha').value,
            };
            
            try {
                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    successMessage.textContent = 'Login realizado com sucesso!';
                    successMessage.classList.add('show');
                    
                    // Armazenar token
                    if (data.token) {
                        localStorage.setItem('auth_token', data.token);
                    }
                    
                    // Mostrar informações do usuário
                    form.style.display = 'none';
                    document.querySelector('.register-link').style.display = 'none';
                    showUserInfo(data);
                    
                } else {
                    errorMessage.textContent = data.message || 'Erro ao realizar login';
                    errorMessage.classList.add('show');
                }
            } catch (error) {
                errorMessage.textContent = 'Erro de conexão. Tente novamente.';
                errorMessage.classList.add('show');
                console.error('Erro:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Entrar';
            }
        });
        
        function showUserInfo(data) {
            document.getElementById('userName').textContent = data.nome_usuario || 'N/A';
            document.getElementById('userEmail').textContent = 'N/A';
            document.getElementById('userToken').textContent = data.token || 'N/A';
            userInfo.classList.add('show');
        }
        
        async function loadUserProfile(token) {
            try {
                const response = await fetch('/api/auth/perfil', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    form.style.display = 'none';
                    document.querySelector('.register-link').style.display = 'none';
                    showUserInfo({...data, token});
                } else {
                    localStorage.removeItem('auth_token');
                }
            } catch (error) {
                console.error('Erro ao carregar perfil:', error);
                localStorage.removeItem('auth_token');
            }
        }
        
        function logout() {
            localStorage.removeItem('auth_token');
            location.reload();
        }
    </script>
</body>
</html>
