-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/07/2023 às 01:48
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";~
SET AUTO_COMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



CREATE DATABASE IF NOT EXISTS hairdresser DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE hairdresser;

--
-- Banco de dados: hairdresser
--

-- --------------------------------------------------------

--
-- Estrutura para tabela schedule
--

CREATE TABLE schedule (
  id int(11) NOT NULL,
  person_id int(11) NOT NULL,
  task_id int(11) NOT NULL,
  date timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela neighborhood
--

CREATE TABLE neighborhood (
  id int(11) NOT NULL,
  city_id int(11) NOT NULL,
  name varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela city
--

CREATE TABLE city (
  id int(11) NOT NULL,
  federative_unit_id int(11) NOT NULL,
  name varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela person
--

CREATE TABLE person (
  id int(11) NOT NULL,
  name varchar(255) NOT NULL,
  user_name varchar(30) DEFAULT NULL,
  password varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela employee
--

CREATE TABLE employee (
  id int(11) NOT NULL,
  person_id int(11) NOT NULL,
  beauty_salon_id int(11) NOT NULL,
  name varchar(255) NOT NULL,
  begin_office_routine time DEFAULT NULL,
  end_office_routine time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela beauty_salon
--

CREATE TABLE beauty_salon (
  id int(11) NOT NULL,
  neighborhood_id int(11) NOT NULL,
  name varchar(60) NOT NULL,
  public_place varchar(255) DEFAULT NULL,
  number int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela task
--

CREATE TABLE task (
  id int(11) NOT NULL,
  employee_id int(11) NOT NULL,
  estimated_minutes int(11) NOT NULL,
  description varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela telephone
--

CREATE TABLE telephone (
  id int(11) NOT NULL,
  person_id int(11) NOT NULL,
  area_number int(11) NOT NULL,
  number int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela federative_unit
--

CREATE TABLE federative_unit (
  id int(11) NOT NULL,
  name varchar(60) NOT NULL,
  acronym varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela federative_unit
--

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela schedule
--
ALTER TABLE schedule
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY idx_schedule__time__task_id (time,task_id) USING BTREE;

--
-- Índices de tabela neighborhood
--
ALTER TABLE neighborhood
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY idx_neighborhood__city_id__name (city_id,name) USING BTREE;

--
-- Índices de tabela city
--
ALTER TABLE city
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY idx_city__federative_unit_id__name (federative_unit_id,name) USING BTREE;

--
-- Índices de tabela person
--
ALTER TABLE person
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY idx_employee__user_name (user_name) USING BTREE,
  ADD UNIQUE KEY idx_person__name (name) USING BTREE;

--
-- Índices de tabela employee
--
ALTER TABLE employee
  ADD PRIMARY KEY (id);

--
-- Índices de tabela beauty_salon
--
ALTER TABLE beauty_salon
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY idx_beauty_salon__public_place__number (public_place,number) USING BTREE;

--
-- Índices de tabela task
--
ALTER TABLE task
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY idx_task__description__employee_id (description,employee_id) USING BTREE;

--
-- Índices de tabela telephone
--
ALTER TABLE telephone
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY idx_telephone__person_id__area_number__number (person_id,area_number,number) USING BTREE;

--
-- Índices de tabela federative_unit
--
ALTER TABLE federative_unit
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY idx_federative_unit__name (name) USING BTREE,
  ADD UNIQUE KEY idx_federative_unit__acronym (acronym) USING BTREE;

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela schedule
--
ALTER TABLE schedule
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela neighborhood
--
ALTER TABLE neighborhood
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela city
--
ALTER TABLE city
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela person
--
ALTER TABLE person
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela employee
--
ALTER TABLE employee
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela beauty_salon
--
ALTER TABLE beauty_salon
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela task
--
ALTER TABLE task
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela telephone
--
ALTER TABLE telephone
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela federative_unit
--
ALTER TABLE federative_unit
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas schedule
--
ALTER TABLE schedule
  ADD CONSTRAINT fk_schedule__person_id FOREIGN KEY (person_id) REFERENCES person (id) ON UPDATE CASCADE,
  ADD CONSTRAINT fk_schedule__task_id FOREIGN KEY (task_id) REFERENCES task (id) ON UPDATE CASCADE;

--
-- Restrições para tabelas neighborhood
--
ALTER TABLE neighborhood
  ADD CONSTRAINT fk_neighborhood__city_id FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE CASCADE;

--
-- Restrições para tabelas city
--
ALTER TABLE city
  ADD CONSTRAINT fk_city__federative_unit_id FOREIGN KEY (federative_unit_id) REFERENCES federative_unit (id) ON UPDATE CASCADE;

--
-- Restrições para tabelas employee
--
ALTER TABLE employee
  ADD CONSTRAINT fk_employee__beauty_salon_id FOREIGN KEY (beauty_salon_id) REFERENCES beauty_salon (id) ON UPDATE CASCADE,
  ADD CONSTRAINT fk_employee__person_id FOREIGN KEY (person_id) REFERENCES person (id) ON UPDATE CASCADE;

--
-- Restrições para tabelas beauty_salon
--
ALTER TABLE beauty_salon
  ADD CONSTRAINT fk_beauty_salon__neighborhood_id FOREIGN KEY (neighborhood_id) REFERENCES neighborhood (id) ON UPDATE CASCADE;

--
-- Restrições para tabelas task
--
ALTER TABLE task
  ADD CONSTRAINT fk_task__employee_id FOREIGN KEY (employee_id) REFERENCES employee (id) ON UPDATE CASCADE;

--
-- Restrições para tabelas telephone
--
ALTER TABLE telephone
  ADD CONSTRAINT fk_telephone__person_id FOREIGN KEY (person_id) REFERENCES person (id) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO federative_unit (name, acronym) VALUES
('Rondônia', 'RO'),
('Acre', 'AC'),
('Amazonas', 'AM'),
('Roraima', 'RR'),
('Pará', 'PA'),
('Amapá', 'AP'),
('Tocantins', 'TO'),
('Maranhão', 'MA'),
('Piauí', 'PI'),
('Ceará', 'CE'),
('Rio Grande do Norte', 'RN'),
('Paraíba', 'PB'),
('Pernambuco', 'PE'),
('Alagoas', 'AL'),
('Sergipe', 'SE'),
('Bahia', 'BA'),
('Minas Gerais', 'MG'),
('Espírito Santo', 'ES'),
('Rio de Janeiro', 'RJ'),
('São Paulo', 'SP'),
('Paraná', 'PR'),
('Santa Catarina', 'SC'),
('Rio Grande do Sul', 'RS'),
('Mato Grosso do Sul', 'MS'),
('Mato Grosso', 'MT'),
('Goiás', 'GO'),
('Distrito Federal', 'DF');

COMMIT;