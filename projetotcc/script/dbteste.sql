-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/10/2023 às 02:06
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dbteste`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tadministrador`
--

CREATE TABLE `tadministrador` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `teducacao`
--

CREATE TABLE `teducacao` (
  `id` int(11) NOT NULL,
  `funcionario_id` int(11) NOT NULL,
  `escolaridade` varchar(50) NOT NULL,
  `nivel_formacao` varchar(50) NOT NULL,
  `especializacao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `teducacao`
--

INSERT INTO `teducacao` (`id`, `funcionario_id`, `escolaridade`, `nivel_formacao`, `especializacao`) VALUES
(1, 1, 'Ensino Médio', 'Completo', NULL),
(2, 2, 'Bacharelado', 'Completo', 'Ciência da Computação'),
(3, 3, 'Mestrado', 'Completo', 'Engenharia de Software');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tferias`
--

CREATE TABLE `tferias` (
  `id` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `funcionario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tfuncionarios`
--

CREATE TABLE `tfuncionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `funcao_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tfuncionarios`
--

INSERT INTO `tfuncionarios` (`id`, `nome`, `data_nascimento`, `telefone`, `funcao_id`) VALUES
(1, 'João Silva', '1990-05-15', '9999-9999', 1),
(2, 'Maria Santos', '1985-10-20', '8888-8888', 2),
(3, 'Pedro Oliveira', '1995-02-28', '7777-7777', 3),
(4, 'Douglas', '2010-10-10', '14996778899', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tfuncoes`
--

CREATE TABLE `tfuncoes` (
  `id` int(11) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `salario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tfuncoes`
--

INSERT INTO `tfuncoes` (`id`, `cargo`, `salario`) VALUES
(1, 'Programador', 5000.00),
(2, 'Analista de Dados', 6000.00),
(3, 'Gerente de Projetos', 8000.00),
(4, 'dev', 100000.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tregistro_horas`
--

CREATE TABLE `tregistro_horas` (
  `id` int(11) NOT NULL,
  `funcionario_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `entrada` time NOT NULL,
  `saida_almoco` time NOT NULL,
  `volta_almoco` time NOT NULL,
  `saida` time NOT NULL,
  `total_horas` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tregistro_horas`
--

INSERT INTO `tregistro_horas` (`id`, `funcionario_id`, `data`, `entrada`, `saida_almoco`, `volta_almoco`, `saida`, `total_horas`) VALUES
(1, 1, '2023-09-20', '08:00:00', '12:00:00', '13:00:00', '17:00:00', 8.00),
(2, 1, '2023-09-21', '08:15:00', '12:15:00', '13:15:00', '17:15:00', 8.00),
(3, 1, '2023-09-22', '08:30:00', '12:30:00', '13:30:00', '17:30:00', 8.00),
(4, 2, '2023-09-20', '09:00:00', '12:30:00', '13:30:00', '18:00:00', 8.50),
(5, 2, '2023-09-21', '09:15:00', '12:45:00', '13:45:00', '18:15:00', 8.50),
(6, 2, '2023-09-22', '09:30:00', '13:00:00', '14:00:00', '18:30:00', 8.50),
(7, 3, '2023-09-20', '08:45:00', '12:15:00', '13:15:00', '17:45:00', 8.00),
(8, 3, '2023-09-21', '09:00:00', '12:30:00', '13:30:00', '18:00:00', 8.50),
(9, 3, '2023-09-22', '09:15:00', '12:45:00', '13:45:00', '18:15:00', 8.50);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tusuarios`
--

CREATE TABLE `tusuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `foto_caminho` varchar(255) DEFAULT NULL,
  `tipo` enum('funcionario','administrador') NOT NULL DEFAULT 'funcionario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tusuarios`
--

INSERT INTO `tusuarios` (`id`, `nome`, `login`, `senha`, `id_funcionario`, `foto_caminho`, `tipo`) VALUES
(1, 'João Silva', 'joao123', 'senha123', 1, NULL, 'funcionario'),
(2, 'Maria Santos', 'maria456', 'senha456', 2, NULL, 'funcionario'),
(3, 'Pedro Oliveira', 'pedro789', 'senha789', 3, NULL, 'funcionario'),
(4, 'Administrador', 'admin', 'admin', NULL, NULL, 'administrador'),
(5, 'Douglas', 'douglas', '123', 4, 'fotos/4_1696544216.jpg', 'funcionario');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tadministrador`
--
ALTER TABLE `tadministrador`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `teducacao`
--
ALTER TABLE `teducacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funcionario_id` (`funcionario_id`);

--
-- Índices de tabela `tferias`
--
ALTER TABLE `tferias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funcionario_id` (`funcionario_id`);

--
-- Índices de tabela `tfuncionarios`
--
ALTER TABLE `tfuncionarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funcao_id` (`funcao_id`);

--
-- Índices de tabela `tfuncoes`
--
ALTER TABLE `tfuncoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tregistro_horas`
--
ALTER TABLE `tregistro_horas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funcionario_id` (`funcionario_id`);

--
-- Índices de tabela `tusuarios`
--
ALTER TABLE `tusuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tadministrador`
--
ALTER TABLE `tadministrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `teducacao`
--
ALTER TABLE `teducacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tferias`
--
ALTER TABLE `tferias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tfuncionarios`
--
ALTER TABLE `tfuncionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tfuncoes`
--
ALTER TABLE `tfuncoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tregistro_horas`
--
ALTER TABLE `tregistro_horas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tusuarios`
--
ALTER TABLE `tusuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `teducacao`
--
ALTER TABLE `teducacao`
  ADD CONSTRAINT `teducacao_ibfk_1` FOREIGN KEY (`funcionario_id`) REFERENCES `tfuncionarios` (`id`);

--
-- Restrições para tabelas `tferias`
--
ALTER TABLE `tferias`
  ADD CONSTRAINT `tferias_ibfk_1` FOREIGN KEY (`funcionario_id`) REFERENCES `tfuncionarios` (`id`);

--
-- Restrições para tabelas `tfuncionarios`
--
ALTER TABLE `tfuncionarios`
  ADD CONSTRAINT `tfuncionarios_ibfk_1` FOREIGN KEY (`funcao_id`) REFERENCES `tfuncoes` (`id`);

--
-- Restrições para tabelas `tregistro_horas`
--
ALTER TABLE `tregistro_horas`
  ADD CONSTRAINT `tregistro_horas_ibfk_1` FOREIGN KEY (`funcionario_id`) REFERENCES `tfuncionarios` (`id`);

--
-- Restrições para tabelas `tusuarios`
--
ALTER TABLE `tusuarios`
  ADD CONSTRAINT `tusuarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `tfuncionarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
