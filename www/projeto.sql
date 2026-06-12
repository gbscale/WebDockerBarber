-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Tempo de geração: 13/05/2026 às 00:59
-- Versão do servidor: 8.0.45
-- Versão do PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `categorias_id` int NOT NULL,
  `categorias_nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`categorias_id`, `categorias_nome`) VALUES
(1, 'Sedã'),
(2, 'Camionete');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `cidades_id` int NOT NULL,
  `cidades_nome` varchar(255) NOT NULL,
  `cidades_uf` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `cidades`
--

INSERT INTO `cidades` (`cidades_id`, `cidades_nome`, `cidades_uf`) VALUES
(2, 'Rialma', 'GO'),
(3, 'Uruaçu', 'GO'),
(5, 'Ceres', 'GO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `enderecos_id` int NOT NULL,
  `enderecos_cidades_id` int NOT NULL,
  `enderecos_usuarios_id` int NOT NULL,
  `enderecos_nome` varchar(255) NOT NULL,
  `enderecos_logradouro` varchar(255) NOT NULL,
  `enderecos_numero` varchar(6) NOT NULL,
  `enderecos_complemento` varchar(255) NOT NULL,
  `enderecos_cep` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`enderecos_id`, `enderecos_cidades_id`, `enderecos_usuarios_id`, `enderecos_nome`, `enderecos_logradouro`, `enderecos_numero`, `enderecos_complemento`, `enderecos_cep`) VALUES
(1, 2, 1, 'minha casa', 'Rua 1000', '10', 'Qd10 Lt20', '76.300-000');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `usuarios_id` int NOT NULL,
  `usuarios_nome` varchar(255) NOT NULL,
  `usuarios_sobrenome` varchar(255) NOT NULL,
  `usuarios_cpf` varchar(14) NOT NULL,
  `usuarios_email` varchar(255) NOT NULL,
  `usuarios_senha` varchar(32) NOT NULL,
  `usuarios_fone` char(15) NOT NULL,
  `usuarios_nivel` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`usuarios_id`, `usuarios_nome`, `usuarios_sobrenome`, `usuarios_cpf`, `usuarios_email`, `usuarios_senha`, `usuarios_fone`, `usuarios_nivel`) VALUES
(1, 'Vilson', 'Soares de Siqueira2', '999.999.999-99', 'vilsonsoares@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '(62)99999-9999', 1),
(2, 'teste', 'teste', '111.111.111-11', 'teste@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '(62)99999-9998', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categorias_id`);

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`cidades_id`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`enderecos_id`),
  ADD KEY `fk_cidade_endereco` (`enderecos_cidades_id`),
  ADD KEY `fk_usuario_endereco` (`enderecos_usuarios_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuarios_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `categorias_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `cidades_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `enderecos_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuarios_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `fk_cidade_endereco` FOREIGN KEY (`enderecos_cidades_id`) REFERENCES `cidades` (`cidades_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario_endereco` FOREIGN KEY (`enderecos_usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Projeto EasyBarber 


CREATE TABLE barbearias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(255),
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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

    FOREIGN KEY (barbearia_id)
        REFERENCES barbearias(id)
);

CREATE TABLE equipe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,

    foto VARCHAR(255),
    descricao TEXT,

    tempo_padrao INT DEFAULT 30,

    FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
);

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

    observacoes TEXT NULL,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE horarios_trabalho (
    id INT AUTO_INCREMENT PRIMARY KEY,

    barbearia_id INT NOT NULL,
    usuario_id INT NOT NULL,

    dia_semana TINYINT NOT NULL,

    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,

    ativo TINYINT DEFAULT 1,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Inserts de exemplo

INSERT INTO barbearias (nome, telefone, email, status)
VALUES ('Barbearia Central', '62999990000', 'contato@central.com', 1);

INSERT INTO usuarios (barbearia_id, nome, email, telefone, senha, cargo, status)
VALUES (
    NULL,
    'Administrador',
    'admin@system.com',
    '00000000000',
    MD5('admin'),
    'admin',
    1
);

INSERT INTO usuarios (barbearia_id, nome, email, telefone, senha, cargo, status)
VALUES (
    1,
    'João Dono',
    'dono@central.com',
    '62988880000',
    MD5('123456'),
    'dono',
    1
);

INSERT INTO usuarios (barbearia_id, nome, email, telefone, senha, cargo, atende_clientes, agenda_ativa, status)
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