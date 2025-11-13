-- ==========================================================
-- Script: entidade.sql
-- Descrição: Tabela base para entidades do sistema.
-- ==========================================================

CREATE TABLE entidade (
    id BIGSERIAL PRIMARY KEY,                     -- Identificador único (chave primária)
    criacao TIMESTAMP NOT NULL DEFAULT NOW(),     -- Data/hora de criação (somente leitura)
    ultima_atualizacao TIMESTAMP NOT NULL         -- Data/hora da última atualização
);

-- Comentários descritivos
COMMENT ON TABLE entidade IS 'Tabela base para todas as entidades do sistema, fornece ID, data de criação e atualização.';
COMMENT ON COLUMN entidade.id IS 'Chave primária, mapeada como identificador único no banco de dados.';
COMMENT ON COLUMN entidade.criacao IS 'Data e hora em que o registro foi criado.';
COMMENT ON COLUMN entidade.ultima_atualizacao IS 'Data e hora da última atualização do registro.';



-- ==========================================================
-- Script: usuario.sql
-- Descrição: Tabela de usuários do sistema, herda de entidade.
-- ==========================================================

CREATE TABLE usuario (
    id BIGSERIAL PRIMARY KEY,                                -- Identificador único
    id_entidade BIGINT NOT NULL REFERENCES entidade(id) ON DELETE CASCADE, -- Relação com entidade
    nome VARCHAR(150) NOT NULL,                              -- Nome completo do usuário
--    cpf CHAR(11) UNIQUE NOT NULL CHECK (cpf ~ '^[0-9]{11}$'), -- CPF (somente números, 11 dígitos)
    email VARCHAR(150) UNIQUE NOT NULL CHECK (email ~* '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$'), -- E-mail válido
    telefone VARCHAR(20),                                    -- Telefone opcional
    data_nascimento DATE,                                    -- Data de nascimento
    ativo BOOLEAN NOT NULL DEFAULT TRUE                      -- Indica se o usuário está ativo
);

-- Índice para busca rápida por nome
CREATE INDEX idx_usuario_nome ON usuario (nome);

-- Comentários descritivos
COMMENT ON TABLE usuario IS 'Tabela que armazena informações básicas dos usuários do sistema.';
COMMENT ON COLUMN usuario.id_entidade IS 'Chave estrangeira para a tabela entidade.';
COMMENT ON COLUMN usuario.nome IS 'Nome completo do usuário.';
COMMENT ON COLUMN usuario.cpf IS 'CPF do usuário, formato numérico com 11 dígitos.';
COMMENT ON COLUMN usuario.email IS 'Endereço de e-mail do usuário.';
COMMENT ON COLUMN usuario.telefone IS 'Número de telefone do usuário.';
COMMENT ON COLUMN usuario.data_nascimento IS 'Data de nascimento.';
COMMENT ON COLUMN usuario.ativo IS 'Indica se o usuário está ativo (TRUE) ou inativo (FALSE).';



-- ==========================================================
-- Script: credencial.sql
-- Descrição: Tabela que armazena as credenciais de acesso dos usuários.
-- ==========================================================

CREATE TABLE credencial (
    id BIGSERIAL PRIMARY KEY,                                         -- Identificador único
    id_usuario BIGINT NOT NULL REFERENCES usuario(id) ON DELETE CASCADE, -- Relação com usuário
    login VARCHAR(100) UNIQUE NOT NULL,                               -- Nome de usuário (login)
    senha_hash TEXT NOT NULL,                                         -- Senha criptografada (hash)
    ultimo_login TIMESTAMP,                                           -- Data e hora do último login
    ativo BOOLEAN NOT NULL DEFAULT TRUE                               -- Indica se a credencial está ativa
);

-- Índice para login
CREATE INDEX idx_credencial_login ON credencial (login);

-- Comentários descritivos
COMMENT ON TABLE credencial IS 'Tabela que armazena as credenciais de acesso (login e senha) dos usuários.';
COMMENT ON COLUMN credencial.id_usuario IS 'Chave estrangeira para o usuário dono da credencial.';
COMMENT ON COLUMN credencial.login IS 'Nome de login único utilizado na autenticação.';
COMMENT ON COLUMN credencial.senha_hash IS 'Senha criptografada utilizando hash seguro.';
COMMENT ON COLUMN credencial.ultimo_login IS 'Data e hora do último acesso do usuário.';
COMMENT ON COLUMN credencial.ativo IS 'Indica se a credencial está ativa.';



-- ==========================================================
-- Script: perfil.sql
-- Descrição: Define os perfis de acesso e permissões dos usuários.
-- ==========================================================

CREATE TABLE perfil (
    id BIGSERIAL PRIMARY KEY,                         -- Identificador único
    nome VARCHAR(100) UNIQUE NOT NULL,                -- Nome do perfil (ex: Administrador, Recrutador, Candidato)
    descricao TEXT,                                   -- Descrição opcional do perfil
    ativo BOOLEAN NOT NULL DEFAULT TRUE               -- Indica se o perfil está ativo
);

-- Tabela intermediária de associação entre usuários e perfis
CREATE TABLE usuario_perfil (
    id_usuario BIGINT NOT NULL REFERENCES usuario(id) ON DELETE CASCADE,
    id_perfil BIGINT NOT NULL REFERENCES perfil(id) ON DELETE CASCADE,
    PRIMARY KEY (id_usuario, id_perfil)
);

-- Índices auxiliares
CREATE INDEX idx_perfil_nome ON perfil (nome);

-- Comentários descritivos
COMMENT ON TABLE perfil IS 'Tabela que define os diferentes perfis de acesso do sistema.';
COMMENT ON COLUMN perfil.nome IS 'Nome único do perfil (exemplo: Administrador, Recrutador, Candidato).';
COMMENT ON COLUMN perfil.descricao IS 'Descrição detalhada do perfil.';
COMMENT ON COLUMN perfil.ativo IS 'Indica se o perfil está ativo (TRUE) ou inativo (FALSE).';

COMMENT ON TABLE usuario_perfil IS 'Tabela de relacionamento N:N entre usuários e perfis.';
COMMENT ON COLUMN usuario_perfil.id_usuario IS 'Chave estrangeira para o usuário.';
COMMENT ON COLUMN usuario_perfil.id_perfil IS 'Chave estrangeira para o perfil.';



-- ==========================================================
-- Script: candidato.sql
-- Descrição: Tabela que armazena informações dos candidatos vinculados a usuários.
-- ==========================================================

CREATE TABLE candidato (
    id BIGSERIAL PRIMARY KEY,                                         -- Identificador único
    id_usuario BIGINT NOT NULL REFERENCES usuario(id) ON DELETE CASCADE, -- Relação 1:1 com usuário
    resumo TEXT,                                                      -- Resumo profissional
    objetivo TEXT,                                                    -- Objetivo de carreira
    pretensao_salarial NUMERIC(10,2),                                 -- Pretensão salarial (opcional)
    cidade VARCHAR(100),                                              -- Cidade de residência
    estado CHAR(2) CHECK (estado ~ '^[A-Z]{2}$'),                     -- Sigla do estado (UF)
    disponibilidade_viagem BOOLEAN DEFAULT FALSE,                     -- Disponibilidade para viagens
    disponibilidade_mudanca BOOLEAN DEFAULT FALSE                     -- Disponibilidade para mudança
);

-- Índice para busca rápida por cidade
CREATE INDEX idx_candidato_cidade ON candidato (cidade);

-- Comentários descritivos
COMMENT ON TABLE candidato IS 'Tabela que armazena informações complementares dos candidatos.';
COMMENT ON COLUMN candidato.id_usuario IS 'Relação 1:1 com o usuário correspondente.';
COMMENT ON COLUMN candidato.resumo IS 'Resumo profissional do candidato.';
COMMENT ON COLUMN candidato.objetivo IS 'Objetivo profissional do candidato.';
COMMENT ON COLUMN candidato.pretensao_salarial IS 'Pretensão salarial (em reais).';
COMMENT ON COLUMN candidato.cidade IS 'Cidade onde o candidato reside.';
COMMENT ON COLUMN candidato.estado IS 'Sigla do estado (UF).';
COMMENT ON COLUMN candidato.disponibilidade_viagem IS 'Indica se o candidato tem disponibilidade para viagens.';
COMMENT ON COLUMN candidato.disponibilidade_mudanca IS 'Indica se o candidato aceita mudar de cidade.';



-- ==========================================================
-- Script: curso.sql
-- Descrição: Armazena os cursos e formações acadêmicas dos candidatos.
-- ==========================================================

CREATE TABLE curso (
    id BIGSERIAL PRIMARY KEY,                                         -- Identificador único
    id_candidato BIGINT NOT NULL REFERENCES candidato(id) ON DELETE CASCADE, -- Relação N:1 com candidato
    nome VARCHAR(150) NOT NULL,                                       -- Nome do curso
    instituicao VARCHAR(150) NOT NULL,                                -- Nome da instituição de ensino
    nivel VARCHAR(50) NOT NULL CHECK (nivel IN ('Técnico', 'Graduação', 'Pós-Graduação', 'Mestrado', 'Doutorado', 'Outros')), -- Nível do curso
    data_inicio DATE NOT NULL,                                        -- Data de início
    data_conclusao DATE,                                              -- Data de conclusão (pode ser nula)
    situacao VARCHAR(30) NOT NULL CHECK (situacao IN ('Concluído', 'Em andamento', 'Trancado')), -- Situação atual
    carga_horaria INTEGER CHECK (carga_horaria >= 0)                  -- Carga horária total (opcional)
);

-- Índices úteis
CREATE INDEX idx_curso_nome ON curso (nome);
CREATE INDEX idx_curso_instituicao ON curso (instituicao);

-- Comentários descritivos
COMMENT ON TABLE curso IS 'Tabela que armazena os cursos e formações acadêmicas de cada candidato.';
COMMENT ON COLUMN curso.id_candidato IS 'Chave estrangeira para o candidato que possui o curso.';
COMMENT ON COLUMN curso.nome IS 'Nome do curso realizado.';
COMMENT ON COLUMN curso.instituicao IS 'Instituição onde o curso foi realizado.';
COMMENT ON COLUMN curso.nivel IS 'Nível do curso (ex: Graduação, Técnico, Mestrado).';
COMMENT ON COLUMN curso.data_inicio IS 'Data de início do curso.';
COMMENT ON COLUMN curso.data_conclusao IS 'Data de conclusão do curso (caso concluído).';
COMMENT ON COLUMN curso.situacao IS 'Situação do curso (Concluído, Em andamento, Trancado).';
COMMENT ON COLUMN curso.carga_horaria IS 'Carga horária total do curso.';



-- ==========================================================
-- Script: experiencia.sql
-- Descrição: Armazena as experiências profissionais dos candidatos.
-- ==========================================================

CREATE TABLE experiencia (
    id BIGSERIAL PRIMARY KEY,                                         -- Identificador único
    id_candidato BIGINT NOT NULL REFERENCES candidato(id) ON DELETE CASCADE, -- Relação N:1 com candidato
    cargo VARCHAR(150) NOT NULL,                                      -- Cargo ocupado
    empresa VARCHAR(150) NOT NULL,                                    -- Nome da empresa
    descricao TEXT,                                                   -- Descrição das atividades
    data_inicio DATE NOT NULL,                                        -- Data de início
    data_fim DATE,                                                    -- Data de término (pode ser nula)
    atual BOOLEAN NOT NULL DEFAULT FALSE,                             -- Indica se é o emprego atual
    cidade VARCHAR(100),                                              -- Cidade onde trabalhou
    estado CHAR(2) CHECK (estado ~ '^[A-Z]{2}$')                      -- Sigla do estado (UF)
);

-- Índices úteis
CREATE INDEX idx_experiencia_empresa ON experiencia (empresa);
CREATE INDEX idx_experiencia_cargo ON experiencia (cargo);

-- Comentários descritivos
COMMENT ON TABLE experiencia IS 'Tabela que armazena as experiências profissionais de cada candidato.';
COMMENT ON COLUMN experiencia.id_candidato IS 'Chave estrangeira para o candidato que possui a experiência.';
COMMENT ON COLUMN experiencia.cargo IS 'Cargo ocupado pelo candidato.';
COMMENT ON COLUMN experiencia.empresa IS 'Nome da empresa onde o candidato trabalhou.';
COMMENT ON COLUMN experiencia.descricao IS 'Descrição detalhada das funções exercidas.';
COMMENT ON COLUMN experiencia.data_inicio IS 'Data de início da experiência profissional.';
COMMENT ON COLUMN experiencia.data_fim IS 'Data de término (pode ser nula se ainda estiver ativo).';
COMMENT ON COLUMN experiencia.atual IS 'Indica se é o emprego atual.';
COMMENT ON COLUMN experiencia.cidade IS 'Cidade onde a experiência ocorreu.';
COMMENT ON COLUMN experiencia.estado IS 'Sigla do estado (UF).';



-- ==========================================================
-- Script: competencia.sql
-- Descrição: Armazena as competências profissionais dos candidatos.
-- ==========================================================

CREATE TABLE competencia (
    id BIGSERIAL PRIMARY KEY,                                         -- Identificador único
    id_candidato BIGINT NOT NULL REFERENCES candidato(id) ON DELETE CASCADE, -- Relação N:1 com candidato
    nome VARCHAR(100) NOT NULL,                                       -- Nome da competência
    nivel VARCHAR(30) NOT NULL CHECK (nivel IN ('Básico', 'Intermediário', 'Avançado', 'Especialista')), -- Nível de proficiência
    descricao TEXT                                                    -- Descrição opcional da competência
);

-- Índices úteis
CREATE INDEX idx_competencia_nome ON competencia (nome);

-- Comentários descritivos
COMMENT ON TABLE competencia IS 'Tabela que armazena as competências e habilidades profissionais dos candidatos.';
COMMENT ON COLUMN competencia.id_candidato IS 'Chave estrangeira para o candidato.';
COMMENT ON COLUMN competencia.nome IS 'Nome da competência (exemplo: Comunicação, Liderança, Programação).';
COMMENT ON COLUMN competencia.nivel IS 'Nível de proficiência do candidato na competência.';
COMMENT ON COLUMN competencia.descricao IS 'Descrição opcional ou observações adicionais.';



-- ==========================================================
-- Script: habilidade.sql
-- Descrição: Armazena as habilidades técnicas e específicas dos candidatos.
-- ==========================================================

CREATE TABLE habilidade (
    id BIGSERIAL PRIMARY KEY,                                         -- Identificador único
    id_candidato BIGINT NOT NULL REFERENCES candidato(id) ON DELETE CASCADE, -- Relação N:1 com candidato
    nome VARCHAR(100) NOT NULL,                                       -- Nome da habilidade
    nivel VARCHAR(30) NOT NULL CHECK (nivel IN ('Básico', 'Intermediário', 'Avançado', 'Especialista')), -- Nível técnico
    descricao TEXT                                                    -- Descrição ou observações
);

-- Índices úteis
CREATE INDEX idx_habilidade_nome ON habilidade (nome);

-- Comentários descritivos
COMMENT ON TABLE habilidade IS 'Tabela que armazena as habilidades técnicas dos candidatos (ex: linguagens, ferramentas, softwares).';
COMMENT ON COLUMN habilidade.id_candidato IS 'Chave estrangeira para o candidato.';
COMMENT ON COLUMN habilidade.nome IS 'Nome da habilidade técnica (ex: Python, SQL, Excel, AutoCAD).';
COMMENT ON COLUMN habilidade.nivel IS 'Nível de domínio do candidato na habilidade.';
COMMENT ON COLUMN habilidade.descricao IS 'Descrição detalhada da habilidade ou certificações relacionadas.';



-- ==========================================================
-- Script: rede_social.sql
-- Descrição: Armazena os perfis de redes sociais dos candidatos.
-- ==========================================================

CREATE TABLE rede_social (
    id BIGSERIAL PRIMARY KEY,                                         -- Identificador único
    id_candidato BIGINT NOT NULL REFERENCES candidato(id) ON DELETE CASCADE, -- Relação N:1 com candidato
    id_tipo_rede_social BIGINT NOT NULL,                              -- Tipo de rede (chave estrangeira definida em tipo_rede_social.sql)
    url VARCHAR(255) NOT NULL,                                        -- Link para o perfil
    ativo BOOLEAN NOT NULL DEFAULT TRUE                               -- Indica se o link está ativo
);

-- Índices úteis
CREATE INDEX idx_rede_social_url ON rede_social (url);

-- Comentários descritivos
COMMENT ON TABLE rede_social IS 'Tabela que armazena as redes sociais associadas a cada candidato.';
COMMENT ON COLUMN rede_social.id_candidato IS 'Chave estrangeira para o candidato.';
COMMENT ON COLUMN rede_social.id_tipo_rede_social IS 'Chave estrangeira para a tabela tipo_rede_social.';
COMMENT ON COLUMN rede_social.url IS 'URL completa para o perfil do candidato na rede social.';
COMMENT ON COLUMN rede_social.ativo IS 'Indica se o perfil informado está ativo.';



-- ==========================================================
-- Script: tipo_rede_social.sql
-- Descrição: Define os tipos de redes sociais disponíveis no sistema.
-- ==========================================================

CREATE TABLE tipo_rede_social (
    id BIGSERIAL PRIMARY KEY,                         -- Identificador único
    nome VARCHAR(100) UNIQUE NOT NULL,                -- Nome da rede social (ex: LinkedIn, GitHub, Instagram)
    descricao TEXT,                                   -- Descrição opcional
    ativo BOOLEAN NOT NULL DEFAULT TRUE               -- Indica se o tipo está ativo
);

-- Inserção inicial de alguns tipos padrão
INSERT INTO tipo_rede_social (nome, descricao) VALUES
('LinkedIn', 'Rede profissional voltada a conexões de trabalho e currículo'),
('GitHub', 'Plataforma para hospedagem de código e projetos'),
('Instagram', 'Rede social voltada a fotos e conteúdo visual'),
('Facebook', 'Rede social de conexões pessoais e profissionais'),
('Twitter/X', 'Rede social de postagens curtas e notícias');

-- Índice útil
CREATE INDEX idx_tipo_rede_social_nome ON tipo_rede_social (nome);

-- Comentários descritivos
COMMENT ON TABLE tipo_rede_social IS 'Tabela que define os tipos de redes sociais disponíveis para associação aos candidatos.';
COMMENT ON COLUMN tipo_rede_social.nome IS 'Nome único da rede social.';
COMMENT ON COLUMN tipo_rede_social.descricao IS 'Descrição ou finalidade da rede social.';
COMMENT ON COLUMN tipo_rede_social.ativo IS 'Indica se o tipo de rede está ativo.';



-- ==========================================================
-- Script: oportunidade.sql
-- Descrição: Armazena as oportunidades de emprego ou estágio.
-- ==========================================================

CREATE TABLE oportunidade (
    id BIGSERIAL PRIMARY KEY,                                         -- Identificador único
    id_entidade BIGINT NOT NULL REFERENCES entidade(id) ON DELETE CASCADE, -- Relacionamento com entidade base
    id_modalidade BIGINT NOT NULL,                                    -- Modalidade (presencial, híbrida, remota)
    codigo VARCHAR(20) NOT NULL,                                      -- Código da oportunidade (maxLength=20)
    titulo VARCHAR(120) NOT NULL,                                     -- Título da vaga (maxLength=120, notNull, notEmpty)
    descricao VARCHAR(500) NOT NULL,                                  -- Descrição detalhada (maxLength=500, notNull, notEmpty)
    requisitos VARCHAR(500),                                          -- Requisitos desejáveis (maxLength=500, notNull, notEmpty)
    beneficios VARCHAR(500),                                          -- Benefícios oferecidos (maxLength=500)
    remuneracao NUMERIC(10,2),                                        -- Valor da remuneração/salário (Decimal)
    vagas INTEGER CHECK (vagas > 0),                                  -- Número de vagas disponíveis (Integer > 0)
    inicio DATE,                                                      -- Data de início (presentOrFuture)
    termino DATE,                                                     -- Data de término (nullOrFuture)
    horario_inicio TIME,                                              -- Horário de início (LocalTime)
    horario_termino TIME,                                             -- Horário de término (LocalTime)
    escala BYTEA,                                                     -- Escala de trabalho (Byte, pode armazenar dados binários ou código)
    localidade VARCHAR(50),                                           -- Localidade/local da vaga (maxLength=50)
    ativo BOOLEAN NOT NULL DEFAULT TRUE                               -- Indica se a vaga está ativa
);

-- Índices úteis
CREATE INDEX idx_oportunidade_codigo ON oportunidade (codigo);
CREATE INDEX idx_oportunidade_titulo ON oportunidade (titulo);
CREATE INDEX idx_oportunidade_ativo ON oportunidade (ativo);

-- Comentários descritivos
COMMENT ON TABLE oportunidade IS 'Tabela que armazena as oportunidades de emprego, estágio ou freelances disponíveis.';
COMMENT ON COLUMN oportunidade.id_entidade IS 'Relação com a entidade responsável pela publicação.';
COMMENT ON COLUMN oportunidade.id_modalidade IS 'Modalidade da vaga (Presencial, Híbrida, Remota).';
COMMENT ON COLUMN oportunidade.codigo IS 'Código único identificador da oportunidade (máximo 20 caracteres).';
COMMENT ON COLUMN oportunidade.titulo IS 'Título ou nome da vaga (máximo 120 caracteres, obrigatório).';
COMMENT ON COLUMN oportunidade.descricao IS 'Descrição detalhada da vaga e responsabilidades (máximo 1500 caracteres, obrigatório).';
COMMENT ON COLUMN oportunidade.requisitos IS 'Requisitos e qualificações desejadas (máximo 500 caracteres, obrigatório).';
COMMENT ON COLUMN oportunidade.beneficios IS 'Benefícios oferecidos pela vaga (máximo 500 caracteres).';
COMMENT ON COLUMN oportunidade.remuneracao IS 'Valor da remuneração ou salário (Decimal).';
COMMENT ON COLUMN oportunidade.vagas IS 'Número de vagas disponíveis (deve ser maior que 0).';
COMMENT ON COLUMN oportunidade.inicio IS 'Data de início da oportunidade (presente ou futuro).';
COMMENT ON COLUMN oportunidade.termino IS 'Data de término da oportunidade (nulo ou futuro).';
COMMENT ON COLUMN oportunidade.horario_inicio IS 'Horário de início do expediente.';
COMMENT ON COLUMN oportunidade.horario_termino IS 'Horário de término do expediente.';
COMMENT ON COLUMN oportunidade.escala IS 'Escala de trabalho (armazenada como byte/binário).';
COMMENT ON COLUMN oportunidade.localidade IS 'Localização física da vaga (máximo 50 caracteres).';
COMMENT ON COLUMN oportunidade.ativo IS 'Indica se a oportunidade está ativa ou encerrada.';



-- ==========================================================
-- Script: tipo_oportunidade.sql
-- Descrição: Define os tipos de oportunidades disponíveis no sistema.
-- ==========================================================

CREATE TABLE tipo_oportunidade (
    id BIGSERIAL PRIMARY KEY,                         -- Identificador único
    nome VARCHAR(100) UNIQUE NOT NULL,                -- Nome do tipo (ex: Emprego, Estágio, Freelance)
    descricao TEXT,                                   -- Descrição opcional
    ativo BOOLEAN NOT NULL DEFAULT TRUE               -- Indica se o tipo está ativo
);

-- Inserção inicial de tipos padrão
INSERT INTO tipo_oportunidade (nome, descricao) VALUES
('Emprego', 'Vaga formal com vínculo empregatício'),
('Estágio', 'Oportunidade para estudantes em formação'),
('Freelance', 'Trabalho temporário ou por projeto'),
('Voluntariado', 'Atividade sem remuneração, com fins sociais');

-- Índice útil
CREATE INDEX idx_tipo_oportunidade_nome ON tipo_oportunidade (nome);

-- Comentários descritivos
COMMENT ON TABLE tipo_oportunidade IS 'Tabela que define os tipos de oportunidades (emprego, estágio, freelance, voluntariado).';
COMMENT ON COLUMN tipo_oportunidade.nome IS 'Nome único do tipo de oportunidade.';
COMMENT ON COLUMN tipo_oportunidade.descricao IS 'Descrição detalhada do tipo de oportunidade.';
COMMENT ON COLUMN tipo_oportunidade.ativo IS 'Indica se o tipo de oportunidade está ativo.';



-- ==========================================================
-- Script: modalidade.sql
-- Descrição: Define as modalidades de trabalho das oportunidades.
-- ==========================================================

CREATE TABLE modalidade (
    id BIGSERIAL PRIMARY KEY,                         -- Identificador único
    nome VARCHAR(100) UNIQUE NOT NULL,                -- Nome da modalidade (ex: Presencial, Remoto, Híbrido)
    descricao TEXT,                                   -- Descrição opcional
    ativo BOOLEAN NOT NULL DEFAULT TRUE               -- Indica se está ativo
);

-- Inserção inicial de modalidades padrão
INSERT INTO modalidade (nome, descricao) VALUES
('Presencial', 'Trabalho realizado integralmente no local da empresa'),
('Remoto', 'Trabalho realizado integralmente a distância'),
('Híbrido', 'Trabalho que combina dias presenciais e remotos');

-- Índice útil
CREATE INDEX idx_modalidade_nome ON modalidade (nome);

-- Comentários descritivos
COMMENT ON TABLE modalidade IS 'Tabela que define as modalidades de trabalho (presencial, remoto, híbrido).';
COMMENT ON COLUMN modalidade.nome IS 'Nome único da modalidade de trabalho.';
COMMENT ON COLUMN modalidade.descricao IS 'Descrição detalhada da modalidade.';
COMMENT ON COLUMN modalidade.ativo IS 'Indica se a modalidade está ativa.';



-- ==========================================================
-- Script: nivel_experiencia.sql
-- Descrição: Define os níveis de experiência para oportunidades e perfis.
-- ==========================================================

CREATE TABLE nivel_experiencia (
    id BIGSERIAL PRIMARY KEY,                           -- Identificador único
    nome VARCHAR(50) UNIQUE NOT NULL,                   -- Nome do nível (ex: Júnior, Pleno, Sênior)
    descricao TEXT,                                     -- Descrição detalhada do nível
    ativo BOOLEAN NOT NULL DEFAULT TRUE                 -- Indica se o nível está ativo
);

-- Inserção inicial de níveis comuns
INSERT INTO nivel_experiencia (nome, descricao) VALUES
('Estagiário', 'Profissional em formação acadêmica, com pouca ou nenhuma experiência prática.'),
('Trainee', 'Profissional em início de carreira, geralmente em programa de capacitação.'),
('Júnior', 'Profissional com pouca experiência, mas capaz de realizar tarefas com supervisão.'),
('Pleno', 'Profissional experiente, capaz de trabalhar de forma autônoma.'),
('Sênior', 'Profissional altamente experiente, capaz de liderar projetos e orientar outros.'),
('Especialista', 'Profissional com domínio técnico avançado em uma área específica.');

-- Índice para otimizar buscas
CREATE INDEX idx_nivel_experiencia_nome ON nivel_experiencia (nome);

-- Comentários explicativos
COMMENT ON TABLE nivel_experiencia IS 'Tabela que define os níveis de experiência dos profissionais ou oportunidades.';
COMMENT ON COLUMN nivel_experiencia.nome IS 'Nome do nível de experiência (ex: Júnior, Pleno, Sênior).';
COMMENT ON COLUMN nivel_experiencia.descricao IS 'Descrição detalhada do nível de experiência.';
COMMENT ON COLUMN nivel_experiencia.ativo IS 'Indica se o nível está ativo.';



-- ==========================================================
-- Script: beneficio.sql
-- Descrição: Define os tipos de benefícios oferecidos pelas oportunidades de trabalho.
-- ==========================================================

CREATE TABLE beneficio (
    id BIGSERIAL PRIMARY KEY,                         -- Identificador único
    nome VARCHAR(100) UNIQUE NOT NULL,                -- Nome do benefício (ex: Vale-refeição, Plano de saúde)
    descricao TEXT,                                   -- Descrição detalhada do benefício
    ativo BOOLEAN NOT NULL DEFAULT TRUE               -- Indica se o benefício está ativo
);

-- Inserção inicial de benefícios comuns
INSERT INTO beneficio (nome, descricao) VALUES
('Vale-refeição', 'Auxílio financeiro para alimentação diária.'),
('Vale-alimentação', 'Crédito mensal para compras em supermercados.'),
('Plano de saúde', 'Assistência médica fornecida pela empresa.'),
('Plano odontológico', 'Cobertura de serviços odontológicos.'),
('Vale-transporte', 'Auxílio para deslocamento casa-trabalho.'),
('Auxílio home office', 'Ajuda de custo para despesas de trabalho remoto.'),
('Gympass', 'Acesso a academias e programas de bem-estar.'),
('Participação nos lucros', 'Bonificação baseada nos resultados da empresa.');

-- Índice para otimizar buscas
CREATE INDEX idx_beneficio_nome ON beneficio (nome);

-- Comentários explicativos
COMMENT ON TABLE beneficio IS 'Tabela que define os benefícios oferecidos pelas oportunidades de trabalho.';
COMMENT ON COLUMN beneficio.nome IS 'Nome do benefício oferecido.';
COMMENT ON COLUMN beneficio.descricao IS 'Descrição detalhada do benefício.';
COMMENT ON COLUMN beneficio.ativo IS 'Indica se o benefício está ativo.';



-- ==========================================================
-- Script: competencia_generica.sql
-- Descrição: Define as competências genéricas disponíveis no sistema.
-- ==========================================================

CREATE TABLE competencia_generica (
    id BIGSERIAL PRIMARY KEY,                         -- Identificador único
    nome VARCHAR(100) UNIQUE NOT NULL,                -- Nome da competência (ex: Comunicação, Liderança)
    descricao TEXT,                                   -- Descrição detalhada da competência
    categoria VARCHAR(50),                            -- Categoria (ex: Técnica, Comportamental, Idiomas)
    ativo BOOLEAN NOT NULL DEFAULT TRUE               -- Indica se a competência está ativa
);

-- Inserção inicial de competências comuns
INSERT INTO competencia_generica (nome, descricao, categoria) VALUES
('Comunicação', 'Habilidade de se expressar claramente e ouvir ativamente', 'Comportamental'),
('Liderança', 'Capacidade de guiar e motivar equipes', 'Comportamental'),
('Trabalho em equipe', 'Colaboração efetiva com colegas', 'Comportamental'),
('Resolução de problemas', 'Análise e solução criativa de desafios', 'Comportamental'),
('Programação', 'Desenvolvimento de software e aplicações', 'Técnica'),
('Gestão de projetos', 'Planejamento e execução de projetos', 'Técnica'),
('Inglês', 'Proficiência no idioma inglês', 'Idiomas'),
('Espanhol', 'Proficiência no idioma espanhol', 'Idiomas');

-- Índice para otimizar buscas
CREATE INDEX idx_competencia_generica_nome ON competencia_generica (nome);
CREATE INDEX idx_competencia_generica_categoria ON competencia_generica (categoria);

-- Comentários explicativos
COMMENT ON TABLE competencia_generica IS 'Tabela que define as competências genéricas disponíveis no sistema.';
COMMENT ON COLUMN competencia_generica.nome IS 'Nome único da competência.';
COMMENT ON COLUMN competencia_generica.descricao IS 'Descrição detalhada da competência.';
COMMENT ON COLUMN competencia_generica.categoria IS 'Categoria da competência (Técnica, Comportamental, Idiomas).';
COMMENT ON COLUMN competencia_generica.ativo IS 'Indica se a competência está ativa.';



-- ==========================================================
-- Script: vaga.sql
-- Descrição: Armazena as vagas de emprego disponíveis.
-- ==========================================================

CREATE TABLE vaga (
    id BIGSERIAL PRIMARY KEY,                                         -- Identificador único
    id_entidade BIGINT NOT NULL REFERENCES entidade(id) ON DELETE CASCADE, -- Relacionamento com entidade base
    id_tipo_oportunidade BIGINT NOT NULL REFERENCES tipo_oportunidade(id), -- Tipo da vaga (Emprego, Estágio, etc)
    codigo VARCHAR(20) UNIQUE NOT NULL,                               -- Código único da vaga
    titulo VARCHAR(120) NOT NULL,                                     -- Título da vaga
    descricao TEXT NOT NULL,                                          -- Descrição detalhada
    requisitos TEXT,                                                  -- Requisitos necessários
    beneficios_texto TEXT,                                            -- Descrição textual de benefícios
    remuneracao NUMERIC(10,2),                                        -- Valor da remuneração
    vagas INTEGER CHECK (vagas > 0),                                  -- Número de vagas disponíveis
    data_abertura DATE NOT NULL DEFAULT CURRENT_DATE,                 -- Data de abertura da vaga
    data_fechamento DATE,                                             -- Data de fechamento (opcional)
    horario_inicio TIME,                                              -- Horário de início do expediente
    horario_termino TIME,                                             -- Horário de término do expediente
    cidade VARCHAR(100),                                              -- Cidade da vaga
    estado CHAR(2) CHECK (estado ~ '^[A-Z]{2}$'),                     -- Sigla do estado (UF)
    cep VARCHAR(10),                                                  -- CEP da localização
    endereco VARCHAR(255),                                            -- Endereço completo
    status VARCHAR(50) NOT NULL DEFAULT 'Aberta',                     -- Status da vaga (Aberta, Fechada, Pausada)
    ativo BOOLEAN NOT NULL DEFAULT TRUE                               -- Indica se a vaga está ativa
);

-- Índices úteis
CREATE INDEX idx_vaga_codigo ON vaga (codigo);
CREATE INDEX idx_vaga_titulo ON vaga (titulo);
CREATE INDEX idx_vaga_status ON vaga (status);
CREATE INDEX idx_vaga_ativo ON vaga (ativo);
CREATE INDEX idx_vaga_cidade ON vaga (cidade);

-- Comentários descritivos
COMMENT ON TABLE vaga IS 'Tabela que armazena as vagas de emprego, estágio ou freelance disponíveis.';
COMMENT ON COLUMN vaga.id_entidade IS 'Relação com a entidade responsável pela publicação.';
COMMENT ON COLUMN vaga.id_tipo_oportunidade IS 'Tipo da oportunidade (Emprego, Estágio, Freelance).';
COMMENT ON COLUMN vaga.codigo IS 'Código único identificador da vaga.';
COMMENT ON COLUMN vaga.titulo IS 'Título ou nome da vaga.';
COMMENT ON COLUMN vaga.descricao IS 'Descrição detalhada da vaga e responsabilidades.';
COMMENT ON COLUMN vaga.requisitos IS 'Requisitos e qualificações desejadas.';
COMMENT ON COLUMN vaga.beneficios_texto IS 'Descrição textual dos benefícios oferecidos.';
COMMENT ON COLUMN vaga.remuneracao IS 'Valor da remuneração ou salário.';
COMMENT ON COLUMN vaga.vagas IS 'Número de vagas disponíveis.';
COMMENT ON COLUMN vaga.data_abertura IS 'Data de abertura da vaga.';
COMMENT ON COLUMN vaga.data_fechamento IS 'Data de fechamento da vaga.';
COMMENT ON COLUMN vaga.horario_inicio IS 'Horário de início do expediente.';
COMMENT ON COLUMN vaga.horario_termino IS 'Horário de término do expediente.';
COMMENT ON COLUMN vaga.cidade IS 'Cidade onde a vaga está localizada.';
COMMENT ON COLUMN vaga.estado IS 'Sigla do estado (UF).';
COMMENT ON COLUMN vaga.cep IS 'CEP da localização.';
COMMENT ON COLUMN vaga.endereco IS 'Endereço completo da vaga.';
COMMENT ON COLUMN vaga.status IS 'Status atual da vaga (Aberta, Fechada, Pausada).';
COMMENT ON COLUMN vaga.ativo IS 'Indica se a vaga está ativa ou encerrada.';



-- ==========================================================
-- Script: vaga_beneficio.sql
-- Descrição: Cria a relação entre as vagas e os benefícios oferecidos.
-- ==========================================================

CREATE TABLE vaga_beneficio (
    id BIGSERIAL PRIMARY KEY,                         -- Identificador único da relação
    id_vaga BIGINT NOT NULL,                          -- FK para a vaga
    id_beneficio BIGINT NOT NULL,                     -- FK para o benefício
    observacao TEXT,                                  -- Observação específica (ex: valor, condições)
    
    CONSTRAINT fk_vaga_beneficio_vaga FOREIGN KEY (id_vaga)
        REFERENCES vaga (id) ON DELETE CASCADE,       -- Se a vaga for excluída, apaga os vínculos
    CONSTRAINT fk_vaga_beneficio_beneficio FOREIGN KEY (id_beneficio)
        REFERENCES beneficio (id) ON DELETE RESTRICT, -- Impede apagar benefício em uso
    CONSTRAINT uq_vaga_beneficio UNIQUE (id_vaga, id_beneficio)  -- Evita duplicação
);

-- Índices para otimizar buscas
CREATE INDEX idx_vaga_beneficio_vaga ON vaga_beneficio (id_vaga);
CREATE INDEX idx_vaga_beneficio_beneficio ON vaga_beneficio (id_beneficio);

-- Comentários explicativos
COMMENT ON TABLE vaga_beneficio IS 'Tabela associativa que relaciona as vagas aos benefícios oferecidos.';
COMMENT ON COLUMN vaga_beneficio.id_vaga IS 'Identificador da vaga.';
COMMENT ON COLUMN vaga_beneficio.id_beneficio IS 'Identificador do benefício.';
COMMENT ON COLUMN vaga_beneficio.observacao IS 'Observações adicionais sobre o benefício nesta vaga.';



-- ==========================================================
-- Script: vaga_modalidade.sql
-- Descrição: Cria a relação entre as vagas e as modalidades de trabalho.
-- ==========================================================

CREATE TABLE vaga_modalidade (
    id BIGSERIAL PRIMARY KEY,                           -- Identificador único da relação
    id_vaga BIGINT NOT NULL,                            -- FK para a vaga
    id_modalidade BIGINT NOT NULL,                      -- FK para a modalidade
    observacao TEXT,                                    -- Observação específica (ex: dias presenciais)

    CONSTRAINT fk_vaga_modalidade_vaga FOREIGN KEY (id_vaga)
        REFERENCES vaga (id) ON DELETE CASCADE,         -- Exclui vínculos ao remover a vaga
    CONSTRAINT fk_vaga_modalidade_modalidade FOREIGN KEY (id_modalidade)
        REFERENCES modalidade (id) ON DELETE RESTRICT,  -- Impede excluir modalidade em uso
    CONSTRAINT uq_vaga_modalidade UNIQUE (id_vaga, id_modalidade)  -- Evita duplicações
);

-- Índices para otimizar buscas
CREATE INDEX idx_vaga_modalidade_vaga ON vaga_modalidade (id_vaga);
CREATE INDEX idx_vaga_modalidade_modalidade ON vaga_modalidade (id_modalidade);

-- Comentários explicativos
COMMENT ON TABLE vaga_modalidade IS 'Tabela associativa que vincula vagas às modalidades de trabalho.';
COMMENT ON COLUMN vaga_modalidade.id_vaga IS 'Identificador da vaga.';
COMMENT ON COLUMN vaga_modalidade.id_modalidade IS 'Identificador da modalidade de trabalho.';
COMMENT ON COLUMN vaga_modalidade.observacao IS 'Detalhes adicionais sobre a modalidade aplicada à vaga.';



-- ==========================================================
-- Script: vaga_nivel_experiencia.sql
-- Descrição: Cria a relação entre as vagas e os níveis de experiência exigidos.
-- ==========================================================

CREATE TABLE vaga_nivel_experiencia (
    id BIGSERIAL PRIMARY KEY,                              -- Identificador único da relação
    id_vaga BIGINT NOT NULL,                               -- FK para a vaga
    id_nivel_experiencia BIGINT NOT NULL,                  -- FK para o nível de experiência
    observacao TEXT,                                       -- Detalhes adicionais (ex: experiência desejável)

    CONSTRAINT fk_vaga_nivel_experiencia_vaga FOREIGN KEY (id_vaga)
        REFERENCES vaga (id) ON DELETE CASCADE,            -- Remove vínculos ao excluir a vaga
    CONSTRAINT fk_vaga_nivel_experiencia_nivel FOREIGN KEY (id_nivel_experiencia)
        REFERENCES nivel_experiencia (id) ON DELETE RESTRICT, -- Impede excluir nível em uso
    CONSTRAINT uq_vaga_nivel_experiencia UNIQUE (id_vaga, id_nivel_experiencia) -- Evita duplicação
);

-- Índices para otimizar buscas
CREATE INDEX idx_vaga_nivel_vaga ON vaga_nivel_experiencia (id_vaga);
CREATE INDEX idx_vaga_nivel_experiencia ON vaga_nivel_experiencia (id_nivel_experiencia);

-- Comentários explicativos
COMMENT ON TABLE vaga_nivel_experiencia IS 'Tabela associativa que vincula vagas aos níveis de experiência exigidos.';
COMMENT ON COLUMN vaga_nivel_experiencia.id_vaga IS 'Identificador da vaga.';
COMMENT ON COLUMN vaga_nivel_experiencia.id_nivel_experiencia IS 'Identificador do nível de experiência.';
COMMENT ON COLUMN vaga_nivel_experiencia.observacao IS 'Observações adicionais sobre o nível de experiência para a vaga.';



-- ==========================================================
-- Script: vaga_competencia.sql
-- Descrição: Cria a relação entre as vagas e as competências exigidas.
-- ==========================================================

CREATE TABLE vaga_competencia (
    id BIGSERIAL PRIMARY KEY,                              -- Identificador único da relação
    id_vaga BIGINT NOT NULL,                               -- FK para a vaga
    id_competencia BIGINT NOT NULL,                        -- FK para a competência genérica
    nivel_requerido VARCHAR(50),                           -- Ex: Básico, Intermediário, Avançado
    obrigatoria BOOLEAN NOT NULL DEFAULT TRUE,             -- Indica se a competência é obrigatória
    observacao TEXT,                                       -- Observações adicionais (ex: certificação desejável)

    CONSTRAINT fk_vaga_competencia_vaga FOREIGN KEY (id_vaga)
        REFERENCES vaga (id) ON DELETE CASCADE,            -- Remove vínculos ao excluir a vaga
    CONSTRAINT fk_vaga_competencia_generica FOREIGN KEY (id_competencia)
        REFERENCES competencia_generica (id) ON DELETE RESTRICT,    -- Impede excluir competência em uso
    CONSTRAINT uq_vaga_competencia UNIQUE (id_vaga, id_competencia) -- Evita duplicação
);

-- Índices para otimizar buscas
CREATE INDEX idx_vaga_competencia_vaga ON vaga_competencia (id_vaga);
CREATE INDEX idx_vaga_competencia_generica ON vaga_competencia (id_competencia);

-- Comentários explicativos
COMMENT ON TABLE vaga_competencia IS 'Tabela associativa que relaciona as vagas às competências genéricas exigidas.';
COMMENT ON COLUMN vaga_competencia.id_vaga IS 'Identificador da vaga.';
COMMENT ON COLUMN vaga_competencia.id_competencia IS 'Identificador da competência genérica exigida.';
COMMENT ON COLUMN vaga_competencia.nivel_requerido IS 'Nível de proficiência exigido para a competência.';
COMMENT ON COLUMN vaga_competencia.obrigatoria IS 'Indica se a competência é obrigatória ou apenas desejável.';
COMMENT ON COLUMN vaga_competencia.observacao IS 'Observações adicionais sobre a competência.';



-- ==========================================================
-- Script: vaga_candidato.sql
-- Descrição: Cria a relação entre candidatos e vagas (inscrições).
-- ==========================================================

CREATE TABLE vaga_candidato (
    id BIGSERIAL PRIMARY KEY,                                 -- Identificador único da inscrição
    id_vaga BIGINT NOT NULL,                                  -- FK para a vaga
    id_candidato BIGINT NOT NULL,                             -- FK para o candidato
    data_inscricao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Data/hora da candidatura
    status VARCHAR(50) NOT NULL DEFAULT 'Em análise',         -- Ex: Em análise, Aprovado, Reprovado
    observacao TEXT,                                          -- Comentários sobre o processo
    pontuacao NUMERIC(5,2),                                   -- Avaliação do candidato (opcional)
    
    CONSTRAINT fk_vaga_candidato_vaga FOREIGN KEY (id_vaga)
        REFERENCES vaga (id) ON DELETE CASCADE,               -- Remove vínculos ao excluir a vaga
    CONSTRAINT fk_vaga_candidato_candidato FOREIGN KEY (id_candidato)
        REFERENCES candidato (id) ON DELETE CASCADE,          -- Remove inscrições ao excluir o candidato
    CONSTRAINT uq_vaga_candidato UNIQUE (id_vaga, id_candidato) -- Evita duplicação de inscrição
);

-- Índices para desempenho
CREATE INDEX idx_vaga_candidato_vaga ON vaga_candidato (id_vaga);
CREATE INDEX idx_vaga_candidato_candidato ON vaga_candidato (id_candidato);

-- Comentários explicativos
COMMENT ON TABLE vaga_candidato IS 'Tabela que registra as inscrições dos candidatos nas vagas.';
COMMENT ON COLUMN vaga_candidato.id_vaga IS 'Identificador da vaga.';
COMMENT ON COLUMN vaga_candidato.id_candidato IS 'Identificador do candidato.';
COMMENT ON COLUMN vaga_candidato.data_inscricao IS 'Data e hora da inscrição.';
COMMENT ON COLUMN vaga_candidato.status IS 'Status atual do processo seletivo.';
COMMENT ON COLUMN vaga_candidato.observacao IS 'Comentários sobre a candidatura.';
COMMENT ON COLUMN vaga_candidato.pontuacao IS 'Pontuação ou avaliação do candidato.';




-- ==========================================================
-- INSERÇÃO DE DADOS DE EXEMPLO
-- ==========================================================

-- 1. Inserindo entidades base
INSERT INTO entidade (ultima_atualizacao) VALUES (NOW());
INSERT INTO entidade (ultima_atualizacao) VALUES (NOW());
INSERT INTO entidade (ultima_atualizacao) VALUES (NOW());
INSERT INTO entidade (ultima_atualizacao) VALUES (NOW());

-- 2. Inserindo usuários
INSERT INTO usuario (id_entidade, nome, email, telefone, data_nascimento, ativo) 
VALUES 
(1, 'João Silva', 'joao.silva@email.com', '11999999999', '1990-05-15', TRUE),
(2, 'Maria Oliveira', 'maria.oliveira@email.com', '21988888888', '1985-10-20', TRUE),
(3, 'Carlos Santos', 'carlos.santos@email.com', '31987777777', '1992-03-25', TRUE);

-- 3. Inserindo credenciais
INSERT INTO credencial (id_usuario, login, senha_hash, ativo) 
VALUES 
(1, 'joaosilva', '$2a$10$hash_senha_joao_exemplo', TRUE),
(2, 'mariaoliveira', '$2a$10$hash_senha_maria_exemplo', TRUE),
(3, 'carlossantos', '$2a$10$hash_senha_carlos_exemplo', TRUE);

-- 4. Inserindo perfis
INSERT INTO perfil (nome, descricao, ativo) 
VALUES 
('Administrador', 'Acesso total ao sistema', TRUE),
('Recrutador', 'Gerencia vagas e processos seletivos', TRUE),
('Candidato', 'Perfil de candidato para vagas', TRUE);

-- 5. Associando usuários a perfis
INSERT INTO usuario_perfil (id_usuario, id_perfil) 
VALUES 
(1, 1), -- João Silva é Administrador
(1, 2), -- João Silva também é Recrutador
(2, 3), -- Maria Oliveira é Candidata
(3, 3); -- Carlos Santos é Candidato

-- 6. Inserindo candidatos
INSERT INTO candidato (id_usuario, resumo, objetivo, pretensao_salarial, cidade, estado, disponibilidade_viagem, disponibilidade_mudanca) 
VALUES 
(2, 'Profissional com 5 anos de experiência em desenvolvimento de software, especializada em Java e Spring Boot.', 
 'Crescer profissionalmente em projetos desafiadores de tecnologia.', 
 7000.00, 'São Paulo', 'SP', TRUE, FALSE),
(3, 'Analista de dados com forte conhecimento em Python, SQL e ferramentas de BI.', 
 'Trabalhar com análise de dados e inteligência de negócios.', 
 5500.00, 'Rio de Janeiro', 'RJ', FALSE, TRUE);

-- 7. Inserindo cursos dos candidatos
INSERT INTO curso (id_candidato, nome, instituicao, nivel, data_inicio, data_conclusao, situacao, carga_horaria)
VALUES
(1, 'Sistemas de Informação', 'Universidade de São Paulo', 'Graduação', '2010-03-01', '2014-12-15', 'Concluído', 3200),
(1, 'Especialização em Arquitetura de Software', 'PUC-SP', 'Pós-Graduação', '2015-02-01', '2016-12-20', 'Concluído', 360),
(2, 'Estatística', 'UFRJ', 'Graduação', '2013-03-01', '2017-12-10', 'Concluído', 2880),
(2, 'Data Science', 'Coursera', 'Outros', '2020-01-15', '2020-06-30', 'Concluído', 120);

-- 8. Inserindo experiências profissionais
INSERT INTO experiencia (id_candidato, cargo, empresa, descricao, data_inicio, data_fim, atual, cidade, estado)
VALUES
(1, 'Desenvolvedora Java', 'Tech Solutions Ltda', 
 'Desenvolvimento de APIs RESTful, manutenção de sistemas legados e implementação de microsserviços.', 
 '2015-01-10', '2018-06-30', FALSE, 'São Paulo', 'SP'),
(1, 'Desenvolvedora Sênior', 'inovaTech', 
 'Liderança técnica de projetos, arquitetura de soluções e mentoria de desenvolvedores juniores.', 
 '2018-07-01', NULL, TRUE, 'São Paulo', 'SP'),
(2, 'Analista de Dados Júnior', 'DataCorp', 
 'Análise exploratória de dados, criação de dashboards e relatórios gerenciais.', 
 '2018-02-01', '2021-12-31', FALSE, 'Rio de Janeiro', 'RJ'),
(2, 'Analista de BI', 'InsightData', 
 'Desenvolvimento de soluções de Business Intelligence, ETL e modelagem de dados.', 
 '2022-01-15', NULL, TRUE, 'Rio de Janeiro', 'RJ');

-- 9. Inserindo competências dos candidatos
INSERT INTO competencia (id_candidato, nome, nivel, descricao)
VALUES
(1, 'Comunicação', 'Avançado', 'Excelente comunicação verbal e escrita em reuniões técnicas'),
(1, 'Liderança', 'Intermediário', 'Experiência liderando pequenas equipes de desenvolvimento'),
(1, 'Trabalho em equipe', 'Avançado', 'Colaboração efetiva em projetos ágeis'),
(2, 'Análise de dados', 'Avançado', 'Forte capacidade analítica e pensamento crítico'),
(2, 'Comunicação', 'Intermediário', 'Boa comunicação de insights técnicos para stakeholders');

-- 10. Inserindo habilidades técnicas dos candidatos
INSERT INTO habilidade (id_candidato, nome, nivel, descricao)
VALUES
(1, 'Java', 'Avançado', 'Java 8+, Spring Boot, Spring Cloud, JPA/Hibernate'),
(1, 'SQL', 'Avançado', 'PostgreSQL, MySQL, otimização de queries'),
(1, 'Docker', 'Intermediário', 'Containerização de aplicações'),
(1, 'Git', 'Avançado', 'Controle de versão, GitFlow, code review'),
(2, 'Python', 'Avançado', 'Pandas, NumPy, Scikit-learn'),
(2, 'SQL', 'Avançado', 'Queries complexas, stored procedures, otimização'),
(2, 'Power BI', 'Avançado', 'Criação de dashboards interativos e relatórios'),
(2, 'Excel', 'Avançado', 'VBA, tabelas dinâmicas, análise avançada');

-- 11. Inserindo redes sociais dos candidatos
INSERT INTO rede_social (id_candidato, id_tipo_rede_social, url, ativo)
VALUES
(1, 1, 'https://linkedin.com/in/maria-oliveira-dev', TRUE),
(1, 2, 'https://github.com/mariaoliveira', TRUE),
(2, 1, 'https://linkedin.com/in/carlos-santos-data', TRUE),
(2, 2, 'https://github.com/carlossantos', TRUE);

-- 12. Inserindo oportunidades (diferente de vagas)
INSERT INTO oportunidade (id_entidade, id_modalidade, codigo, titulo, descricao, requisitos, beneficios, 
                        remuneracao, vagas, inicio, termino, horario_inicio, horario_termino, localidade, ativo)
VALUES
(4, 1, 'OPT-001', 'Programa de Estágio em TI', 
 'Oportunidade para estudantes de tecnologia adquirirem experiência prática.', 
 'Cursando graduação em TI, conhecimento básico de programação.', 
 'Vale-transporte, Vale-refeição, Seguro de vida', 
 1500.00, 5, '2025-02-01', '2025-12-31', '09:00:00', '15:00:00', 'São Paulo - SP', TRUE);

-- 13. Inserindo vagas de emprego
INSERT INTO vaga (id_entidade, id_tipo_oportunidade, codigo, titulo, descricao, requisitos, 
                beneficios_texto, remuneracao, vagas, cidade, estado, horario_inicio, horario_termino, ativo)
VALUES 
(4, 1, 'VAGA-001', 'Desenvolvedor Full Stack', 
 'Desenvolvimento de aplicações web modernas utilizando tecnologias front-end e back-end.', 
 'Experiência com JavaScript, React, Node.js e bancos de dados relacionais.',
 'Vale-refeição, Plano de saúde, Home office flexível, PLR', 
 8000.00, 2, 'São Paulo', 'SP', '09:00:00', '18:00:00', TRUE),
(4, 1, 'VAGA-002', 'Analista de Dados Sênior', 
 'Análise de grandes volumes de dados, criação de modelos preditivos e dashboards estratégicos.', 
 'Graduação completa, experiência com Python, SQL, Power BI e ferramentas de Machine Learning.',
 'Vale-refeição, Plano de saúde e odontológico, Gympass, Auxílio home office', 
 9000.00, 1, 'Rio de Janeiro', 'RJ', '08:00:00', '17:00:00', TRUE),
(4, 2, 'VAGA-003', 'Estagiário de Marketing Digital', 
 'Apoio nas estratégias de marketing digital, gestão de redes sociais e análise de métricas.', 
 'Cursando Marketing, Publicidade ou áreas afins. Conhecimento em redes sociais.',
 'Vale-transporte, Vale-refeição', 
 1800.00, 3, 'Belo Horizonte', 'MG', '09:00:00', '15:00:00', TRUE);

-- 14. Associando vagas a benefícios
INSERT INTO vaga_beneficio (id_vaga, id_beneficio, observacao)
VALUES
(1, 1, 'R$ 30,00 por dia útil'),
(1, 3, 'Plano de saúde com coparticipação'),
(1, 6, 'R$ 200,00 mensais'),
(2, 1, 'R$ 35,00 por dia útil'),
(2, 3, 'Plano de saúde sem coparticipação'),
(2, 4, 'Cobertura completa'),
(2, 7, 'Acesso a rede credenciada'),
(3, 1, 'R$ 20,00 por dia útil'),
(3, 5, 'Cartão de transporte fornecido');

-- 15. Associando vagas a modalidades
INSERT INTO vaga_modalidade (id_vaga, id_modalidade, observacao)
VALUES
(1, 3, '3 dias presenciais, 2 dias remotos'),
(2, 2, 'Trabalho 100% remoto'),
(3, 1, 'Presencial de segunda a sexta');

-- 16. Associando vagas a níveis de experiência
INSERT INTO vaga_nivel_experiencia (id_vaga, id_nivel_experiencia, observacao)
VALUES
(1, 4, 'Experiência mínima de 3 anos'),
(1, 5, 'Profissional com ampla experiência'),
(2, 5, 'Experiência sênior obrigatória'),
(3, 1, 'Estudante universitário');

-- 17. Associando competências genéricas às vagas
INSERT INTO vaga_competencia (id_vaga, id_competencia, nivel_requerido, obrigatoria, observacao)
VALUES
(1, 1, 'Avançado', TRUE, 'Comunicação essencial para trabalho em equipe'),
(1, 5, 'Avançado', TRUE, 'Conhecimento sólido em programação'),
(1, 3, 'Intermediário', TRUE, 'Colaboração em projetos ágeis'),
(2, 4, 'Avançado', TRUE, 'Análise de problemas complexos'),
(2, 1, 'Intermediário', FALSE, 'Apresentação de resultados'),
(3, 1, 'Básico', TRUE, 'Comunicação básica necessária');

-- 18. Inserindo inscrições de candidatos em vagas
INSERT INTO vaga_candidato (id_vaga, id_candidato, status, observacao, pontuacao)
VALUES 
(1, 1, 'Em análise', 'Currículo com boa aderência aos requisitos.', 85.50),
(2, 2, 'Aprovado para entrevista', 'Perfil muito interessante, agendar entrevista técnica.', 92.00),
(3, 2, 'Não qualificado', 'Candidato overqualified para posição de estágio.', NULL);

-- FIM DOS INSERTS DE EXEMPLO