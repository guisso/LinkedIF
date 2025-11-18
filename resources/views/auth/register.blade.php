<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - LinkedIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-registro {
            max-width: 700px;
            margin: 50px auto;
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card card-registro shadow-lg border-0">
            <div class="card-header bg-success text-white text-center py-3">
                <h4 class="mb-0">Crie sua conta no LinkedIF</h4>
            </div>
            <div class="card-body p-4">

                <div id="alert-area"></div>

                <form id="formRegistro">

                    <div class="mb-4 p-3 bg-light border rounded">
                        <label class="form-label fw-bold text-success">Primeiro, quem é você?</label>
                        <select class="form-select form-select-lg" id="tipo_perfil" name="tipo_perfil" required>
                            <option value="" selected disabled>Selecione seu perfil...</option>
                            <option value="ALUNO">🎓 Aluno (Discente)</option>
                            <option value="EMPRESA">🏢 Empresa (Parceiro)</option>
                            <option value="PROFESSOR">📚 Professor (Docente)</option>
                        </select>
                        <div class="form-text">Os campos abaixo mudarão conforme sua escolha.</div>
                    </div>

                    <h5 class="mb-3 text-secondary">Dados Gerais</h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nome Completo / Razão Social <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nome" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="telefone" placeholder="(38) 99999-9999" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data de Nascimento (ou Fundação) <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="nascimento" required>
                        </div>
                        <div class="col-md-6 mb-3 pt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="whatsapp" value="1" id="whatsapp">
                                <label class="form-check-label" for="whatsapp">Este número é WhatsApp?</label>
                            </div>
                        </div>
                    </div>

                    <div id="campos-aluno" class="hidden p-3 mb-4 border border-primary border-opacity-50 rounded bg-primary-subtle">
                        <h6 class="text-primary fw-bold">🎓 Dados Acadêmicos</h6>
                        <div class="mb-3">
                            <label class="form-label">Qual seu Curso? <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="input-curso" name="curso" placeholder="Ex: Ciência da Computação">
                        </div>
                    </div>

                    <div id="campos-empresa" class="hidden p-3 mb-4 border border-warning border-opacity-50 rounded bg-warning-subtle">
                        <h6 class="text-warning-emphasis fw-bold">🏢 Dados Empresariais</h6>
                        <div class="mb-3">
                            <label class="form-label">CNPJ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="input-cnpj" name="cnpj" placeholder="Apenas números (14 dígitos)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição da Empresa</label>
                            <textarea class="form-control" id="input-descricao" name="descricao" rows="3" placeholder="Fale um pouco sobre a empresa..."></textarea>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3 text-secondary">Dados de Acesso</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome de Usuário (Login) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nome_usuario" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Senha <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="senha" minlength="6" required>
                            <div class="form-text">Mínimo de 6 caracteres.</div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg fw-bold" id="btn-submit">CADASTRAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // --- Elementos do DOM ---
        const selectPerfil = document.getElementById('tipo_perfil');
        const divAluno = document.getElementById('campos-aluno');
        const divEmpresa = document.getElementById('campos-empresa');
        const inputCurso = document.getElementById('input-curso');
        const inputCnpj = document.getElementById('input-cnpj');

        const form = document.getElementById('formRegistro');
        const alertArea = document.getElementById('alert-area');
        const btnSubmit = document.getElementById('btn-submit');

        // --- 1. Lógica de Mostrar/Esconder Campos ---
        selectPerfil.addEventListener('change', function () {
            const valor = this.value;

            // 1. Esconde tudo primeiro
            divAluno.classList.add('hidden');
            divEmpresa.classList.add('hidden');

            // 2. Remove a obrigatoriedade dos campos escondidos (para não travar o HTML5 validation)
            inputCurso.required = false;
            inputCnpj.required = false;

            // 3. Mostra o que foi selecionado e torna obrigatório
            if (valor === 'ALUNO') {
                divAluno.classList.remove('hidden');
                inputCurso.required = true; // Curso é obrigatório para aluno
            }
            else if (valor === 'EMPRESA') {
                divEmpresa.classList.remove('hidden');
                inputCnpj.required = true; // CNPJ é obrigatório para empresa
            }
            // Nota: Professor usa a lógica padrão (sem campos extras obrigatórios por enquanto)
        });

        // --- 2. Envio do Formulário para a API ---
        form.addEventListener('submit', async function (e) {
            e.preventDefault(); // Impede o recarregamento da página

            // UI de carregamento
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...';
            alertArea.innerHTML = '';

            // Coleta os dados
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            // Corrige o checkbox (transforma em booleano)
            data.whatsapp = formData.get('whatsapp') ? true : false;

            try {
                // Faz a requisição para o seu AuthController
                const response = await fetch('http://127.0.0.1:8000/api/v1/registro', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    // SUCESSO 201
                    alertArea.innerHTML = `
                    <div class="alert alert-success border-success">
                        <strong>Sucesso!</strong> ${result.message}
                    </div>`;

                    // Limpa o formulário
                    form.reset();
                    divAluno.classList.add('hidden');
                    divEmpresa.classList.add('hidden');

                    // Rola para o topo para ver a mensagem
                    window.scrollTo(0, 0);

                } else {
                    // ERRO (Validação 422 ou Servidor 500)
                    let errorMsg = result.message || 'Erro desconhecido.';

                    // Se tiver lista de erros de validação
                    if (result.errors) {
                        errorMsg += '<ul class="mt-2 mb-0">';
                        for (const [key, value] of Object.entries(result.errors)) {
                            errorMsg += `<li>${value}</li>`;
                        }
                        errorMsg += '</ul>';
                    }

                    alertArea.innerHTML = `
                    <div class="alert alert-danger border-danger">
                        <strong>Erro:</strong> ${errorMsg}
                    </div>`;
                    window.scrollTo(0, 0);
                }

            } catch (error) {
                console.error('Erro de rede:', error);
                alertArea.innerHTML = `
                <div class="alert alert-danger">
                    <strong>Erro de Conexão:</strong> Não foi possível contactar o servidor. Verifique se o Laravel está rodando.
                </div>`;
                window.scrollTo(0, 0);
            } finally {
                // Restaura o botão
                btnSubmit.disabled = false;
                btnSubmit.innerText = 'CADASTRAR';
            }
        });
    </script>

</body>

</html>