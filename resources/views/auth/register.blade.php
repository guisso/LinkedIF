<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - LinkedIF</title>
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

                <form id="formRegistro" class="login-form">

                    <div class="profile-selector">
                        <label for="tipo_perfil">Primeiro, quem é você?</label>
                        <select id="tipo_perfil" name="tipo_perfil" required>
                            <option value="" selected disabled>Selecione seu perfil...</option>
                            <option value="ALUNO">🎓 Aluno (Discente)</option>
                            <option value="EMPRESA">🏢 Empresa (Parceiro)</option>
                            <option value="PROFESSOR">📚 Professor (Docente)</option>
                        </select>
                        <div class="form-text">Os campos abaixo mudarão conforme sua escolha.</div>
                    </div>

                    <h2 class="form-section-title">Dados Gerais</h2>

                    <div class="form-group">
                        <label for="nome">Nome Completo / Razão Social <span style="color: var(--error);">*</span></label>
                        <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required />
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">E-mail <span style="color: var(--error);">*</span></label>
                            <input type="email" id="email" name="email" placeholder="seu.email@exemplo.com" required />
                        </div>

                        <div class="form-group">
                            <label for="telefone">Telefone <span style="color: var(--error);">*</span></label>
                            <input type="text" id="telefone" name="telefone" placeholder="(38) 99999-9999" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="nascimento">Data de Nascimento (ou Fundação) <span style="color: var(--error);">*</span></label>
                            <input type="date" id="nascimento" name="nascimento" required />
                        </div>

                        <div class="form-group" style="display: flex; align-items: flex-end;">
                            <div class="form-check">
                                <input type="checkbox" id="whatsapp" name="whatsapp" value="1" />
                                <label for="whatsapp">Este número é WhatsApp?</label>
                            </div>
                        </div>
                    </div>

                    <div id="campos-aluno" class="campos-especificos campos-aluno hidden">
                        <h6>🎓 Dados Acadêmicos</h6>
                        <div class="form-group">
                            <label for="input-curso">Qual seu Curso? <span style="color: var(--error);">*</span></label>
                            <input type="text" id="input-curso" name="curso" placeholder="Ex: Ciência da Computação" />
                        </div>
                    </div>

                    <div id="campos-empresa" class="campos-especificos campos-empresa hidden">
                        <h6>🏢 Dados Empresariais</h6>
                        <div class="form-group">
                            <label for="input-cnpj">CNPJ <span style="color: var(--error);">*</span></label>
                            <input type="text" id="input-cnpj" name="cnpj" placeholder="Apenas números (14 dígitos)" />
                        </div>
                        <div class="form-group">
                            <label for="input-descricao">Descrição da Empresa</label>
                            <textarea id="input-descricao" name="descricao" rows="3" placeholder="Fale um pouco sobre a empresa..."></textarea>
                        </div>
                    </div>

                    <div id="campos-professor" class="campos-especificos campos-professor hidden">
                        <h6>📚 Dados Acadêmicos</h6>
                        <p style="font-size: 0.9rem; color: var(--gray-dark); margin: 0;">
                            Os campos gerais já são suficientes para professores.
                        </p>
                    </div>

                    <h2 class="form-section-title">Dados de Acesso</h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome_usuario">Nome de Usuário (Login) <span style="color: var(--error);">*</span></label>
                            <input type="text" id="nome_usuario" name="nome_usuario" placeholder="seu_usuario" required />
                        </div>

                        <div class="form-group">
                            <label for="senha">Senha <span style="color: var(--error);">*</span></label>
                            <input type="password" id="senha" name="senha" placeholder="Mínimo 6 caracteres" minlength="6" required />
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="btn-submit">
                        Cadastrar
                    </button>
                </form>

                <div class="divider">
                    <span>ou</span>
                </div>

                <div class="toggle-mode">
                    <p>
                        Já tem uma conta?
                        <a href="/login" class="link-button">Faça login</a>
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
        const selectPerfil = document.getElementById('tipo_perfil');
        const divAluno = document.getElementById('campos-aluno');
        const divEmpresa = document.getElementById('campos-empresa');
        const divProfessor = document.getElementById('campos-professor');
        const inputCurso = document.getElementById('input-curso');
        const inputCnpj = document.getElementById('input-cnpj');

        const form = document.getElementById('formRegistro');
        const alertArea = document.getElementById('alert-area');
        const btnSubmit = document.getElementById('btn-submit');

        // Mostra/esconde campos específicos conforme tipo de perfil selecionado
        selectPerfil.addEventListener('change', function () {
            const valor = this.value;

            divAluno.classList.add('hidden');
            divEmpresa.classList.add('hidden');
            divProfessor.classList.add('hidden');

            inputCurso.required = false;
            inputCnpj.required = false;

            if (valor === 'ALUNO') {
                divAluno.classList.remove('hidden');
                inputCurso.required = true;
            }
            else if (valor === 'EMPRESA') {
                divEmpresa.classList.remove('hidden');
                inputCnpj.required = true;
            }
            else if (valor === 'PROFESSOR') {
                divProfessor.classList.remove('hidden');
            }
        });

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            btnSubmit.disabled = true;
            const originalText = btnSubmit.textContent;
            btnSubmit.innerHTML = '<span class="spinner"></span> Enviando...';
            alertArea.innerHTML = '';

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            data.whatsapp = formData.get('whatsapp') ? true : false;

            try {
                const response = await fetch('/api/v1/registro', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    alertArea.innerHTML = `<div class="success-message"><strong>Sucesso!</strong> ${result.message}</div>`;

                    form.reset();
                    divAluno.classList.add('hidden');
                    divEmpresa.classList.add('hidden');
                    divProfessor.classList.add('hidden');

                    window.scrollTo({ top: 0, behavior: 'smooth' });

                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 2000);

                } else {
                    let errorMsg = result.message || 'Erro desconhecido.';

                    if (result.errors) {
                        errorMsg += '<ul style="margin-top: 0.5rem; margin-bottom: 0; padding-left: 1.5rem;">';
                        for (const [key, value] of Object.entries(result.errors)) {
                            errorMsg += `<li>${value}</li>`;
                        }
                        errorMsg += '</ul>';
                    }

                    alertArea.innerHTML = `<div class="error-message"><strong>Erro:</strong> ${errorMsg}</div>`;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }

            } catch (error) {
                console.error('Erro de rede:', error);
                alertArea.innerHTML = '<div class="error-message"><strong>Erro de Conexão:</strong> Não foi possível contactar o servidor. Verifique se o Laravel está rodando.</div>';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.textContent = originalText;
            }
        });
    </script>

</body>

</html>
