-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/07/2023 às 03:36
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
-- Banco de dados: `hairdresser`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL,
  `horario` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `bairro`
--

CREATE TABLE `bairro` (
  `id` int(11) NOT NULL,
  `cidade_id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidade`
--

CREATE TABLE `cidade` (
  `id` int(11) NOT NULL,
  `uf_id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `salao_id` int(11) NOT NULL,
  `inicio_expediente` time NOT NULL,
  `final_expediente` time NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `senha` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `salao`
--

CREATE TABLE `salao` (
  `id` int(11) NOT NULL,
  `bairro_id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `logradouro` varchar(255) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servico`
--

CREATE TABLE `servico` (
  `id` int(11) NOT NULL,
  `funcionario_id` int(11) NOT NULL,
  `tempo_estimado_minutos` int(11) NOT NULL,
  `descricao` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone`
--

CREATE TABLE `telefone` (
  `id` int(11) NOT NULL,
  `funcionario_id` int(11) NOT NULL,
  `ddd` int(11) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `uf`
--

CREATE TABLE `uf` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `sigla` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `uf`
--

INSERT INTO `uf` (`id`, `nome`, `sigla`) VALUES
(1, 'Rondônia', 'RO'),
(2, 'Acre', 'AC'),
(3, 'Amazonas', 'AM'),
(4, 'Roraima', 'RR'),
(5, 'Pará', 'PA'),
(6, 'Amapá', 'AP'),
(7, 'Tocantins', 'TO'),
(8, 'Maranhão', 'MA'),
(9, 'Piauí', 'PI'),
(10, 'Ceará', 'CE'),
(11, 'Rio Grande do Norte', 'RN'),
(12, 'Paraíba', 'PB'),
(13, 'Pernambuco', 'PE'),
(14, 'Alagoas', 'AL'),
(15, 'Sergipe', 'SE'),
(16, 'Bahia', 'BA'),
(17, 'Minas Gerais', 'MG'),
(18, 'Espírito Santo', 'ES'),
(19, 'Rio de Janeiro', 'RJ'),
(20, 'São Paulo', 'SP'),
(21, 'Paraná', 'PR'),
(22, 'Santa Catarina', 'SC'),
(23, 'Rio Grande do Sul', 'RS'),
(24, 'Mato Grosso do Sul', 'MS'),
(25, 'Mato Grosso', 'MT'),
(26, 'Goiás', 'GO'),
(27, 'Distrito Federal', 'DF');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_agendamento__horario__servico_id` (`horario`,`servico_id`),
  ADD KEY `fk_agendamento__cliente_id` (`cliente_id`),
  ADD KEY `fk_agendamento__servico_id` (`servico_id`);

--
-- Índices de tabela `bairro`
--
ALTER TABLE `bairro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_bairro__cidade_id__nome` (`cidade_id`,`nome`);

--
-- Índices de tabela `cidade`
--
ALTER TABLE `cidade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cidade__uf_id__nome` (`uf_id`,`nome`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cliente__nome` (`nome`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_funcionario__usuario` (`usuario`),
  ADD KEY `fk_funcionario__salao_id` (`salao_id`);

--
-- Índices de tabela `salao`
--
ALTER TABLE `salao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_salao__logradouro__numero` (`logradouro`,`numero`),
  ADD KEY `fk_salao__bairro_id` (`bairro_id`);

--
-- Índices de tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_servico__descricao__funcionario_id` (`descricao`,`funcionario_id`),
  ADD KEY `fk_servico__funcionario_id` (`funcionario_id`);

--
-- Índices de tabela `telefone`
--
ALTER TABLE `telefone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_telefone__funcionario_id__ddd__numero` (`funcionario_id`,`ddd`,`numero`);

--
-- Índices de tabela `uf`
--
ALTER TABLE `uf`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_uf__nome` (`nome`),
  ADD KEY `idx_uf__sigla` (`sigla`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `bairro`
--
ALTER TABLE `bairro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cidade`
--
ALTER TABLE `cidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `salao`
--
ALTER TABLE `salao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `uf`
--
ALTER TABLE `uf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamento`
--
ALTER TABLE `agendamento`
  ADD CONSTRAINT `fk_agendamento__cliente_id` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_agendamento__servico_id` FOREIGN KEY (`servico_id`) REFERENCES `servico` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `bairro`
--
ALTER TABLE `bairro`
  ADD CONSTRAINT `fk_bairro__cidade_id` FOREIGN KEY (`cidade_id`) REFERENCES `cidade` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `cidade`
--
ALTER TABLE `cidade`
  ADD CONSTRAINT `fk_cidade__uf_id` FOREIGN KEY (`uf_id`) REFERENCES `uf` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `fk_funcionario__salao_id` FOREIGN KEY (`salao_id`) REFERENCES `salao` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `salao`
--
ALTER TABLE `salao`
  ADD CONSTRAINT `fk_salao__bairro_id` FOREIGN KEY (`bairro_id`) REFERENCES `bairro` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `servico`
--
ALTER TABLE `servico`
  ADD CONSTRAINT `fk_servico__funcionario_id` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionario` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `telefone`
--
ALTER TABLE `telefone`
  ADD CONSTRAINT `fk_telefone__funcionario_id` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionario` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
