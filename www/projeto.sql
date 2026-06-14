SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET FOREIGN_KEY_CHECKS = 0;

-- Remove tabelas do EasyBarber (caso já existam)
DROP TABLE IF EXISTS agendamentos;
DROP TABLE IF EXISTS horarios_trabalho;
DROP TABLE IF EXISTS equipe;
DROP TABLE IF EXISTS servicos;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS barbearias;

-- Remove tabelas do projeto antigo
DROP TABLE IF EXISTS enderecos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS cidades;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- BARBEARIAS
-- =====================================================

CREATE TABLE barbearias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(255),
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- USUARIOS
-- =====================================================

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,

    barbearia_id INT NULL,

    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefone VARCHAR(20),
    senha VARCHAR(255) NOT NULL,

    cargo ENUM(
        'admin',
        'dono',
        'barbeiro'
    ) NOT NULL,

    atende_clientes TINYINT DEFAULT 0,
    agenda_ativa TINYINT DEFAULT 1,
    status TINYINT DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuario_barbearia
    FOREIGN KEY (barbearia_id)
    REFERENCES barbearias(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- EQUIPE
-- =====================================================

CREATE TABLE equipe (
    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT NOT NULL,

    foto VARCHAR(255),
    descricao TEXT,

    tempo_padrao INT DEFAULT 30,

    CONSTRAINT fk_equipe_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- SERVICOS
-- =====================================================

CREATE TABLE servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,

    barbearia_id INT NOT NULL,

    nome VARCHAR(150) NOT NULL,
    descricao TEXT,

    valor DECIMAL(10,2) NOT NULL,
    duracao INT NOT NULL DEFAULT 30,

    status TINYINT DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_servico_barbearia
    FOREIGN KEY (barbearia_id)
    REFERENCES barbearias(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- AGENDAMENTOS
-- =====================================================

CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,

    barbearia_id INT NOT NULL,
    usuario_id INT NOT NULL,
    servico_id INT NOT NULL,

    cliente_nome VARCHAR(150) NOT NULL,
    cliente_telefone VARCHAR(20) NOT NULL,

    data_agendamento DATE NOT NULL,

    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,

    valor DECIMAL(10,2) NOT NULL,

    status ENUM(
        'agendado',
        'confirmado',
        'concluido',
        'cancelado'
    ) DEFAULT 'agendado',

    observacoes TEXT,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_agendamento_barbearia
    FOREIGN KEY (barbearia_id)
    REFERENCES barbearias(id),

    CONSTRAINT fk_agendamento_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id),

    CONSTRAINT fk_agendamento_servico
    FOREIGN KEY (servico_id)
    REFERENCES servicos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- HORARIOS DE TRABALHO
-- =====================================================

CREATE TABLE horarios_trabalho (
    id INT AUTO_INCREMENT PRIMARY KEY,

    barbearia_id INT NOT NULL,
    usuario_id INT NOT NULL,

    dia_semana TINYINT NOT NULL,

    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,

    ativo TINYINT DEFAULT 1,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_horario_barbearia
    FOREIGN KEY (barbearia_id)
    REFERENCES barbearias(id),

    CONSTRAINT fk_horario_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- DADOS INICIAIS
-- =====================================================

INSERT INTO barbearias (
    nome,
    telefone,
    email,
    status
)
VALUES (
    'Barbearia Central',
    '62999990000',
    'contato@central.com',
    1
);

INSERT INTO usuarios (
    barbearia_id,
    nome,
    email,
    telefone,
    senha,
    cargo,
    status
)
VALUES (
    NULL,
    'Administrador',
    'admin@system.com',
    '00000000000',
    MD5('admin'),
    'admin',
    1
);

INSERT INTO usuarios (
    barbearia_id,
    nome,
    email,
    telefone,
    senha,
    cargo,
    status
)
VALUES (
    1,
    'João Dono',
    'dono@central.com',
    '62988880000',
    MD5('123456'),
    'dono',
    1
);

INSERT INTO usuarios (
    barbearia_id,
    nome,
    email,
    telefone,
    senha,
    cargo,
    atende_clientes,
    agenda_ativa,
    status
)
VALUES (
    1,
    'Carlos Barbearia',
    'barbeiro@central.com',
    '62977770000',
    MD5('123456'),
    'barbeiro',
    1,
    1,
    1
);

INSERT INTO servicos (
    barbearia_id,
    nome,
    descricao,
    valor,
    duracao
)
VALUES (
    1,
    'Corte Masculino',
    'Corte tradicional',
    35.00,
    30
);

COMMIT;