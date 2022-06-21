-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 15-Set-2019 às 18:50
-- Versão do servidor: 10.1.35-MariaDB
-- versão do PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s-ex`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administra`
--

CREATE TABLE `administra` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `administra`
--

INSERT INTO `administra` (`id`, `id_user`, `id_turma`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_professor` varchar(100) NOT NULL,
  `disciplina` varchar(100) NOT NULL,
  `cod_turma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`id`, `nome`, `email`, `id_professor`, `disciplina`, `cod_turma`) VALUES
(1, 'joão', 'joao@s-ex.com.br', '1', 'Matematica', 1),
(2, 'maria', 'maria@s-ex.com.br', '1', 'Matemática', 2),
(3, 'Mateus', 'mateus@s-ex.com.br', '1', 'Matemática', 2),
(4, 'Jaqueline', 'jaqueline@s-ex.com.br', '1', 'Matemática', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `assiste`
--

CREATE TABLE `assiste` (
  `id` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `assiste`
--

INSERT INTO `assiste` (`id`, `id_aula`, `id_turma`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aulas`
--

CREATE TABLE `aulas` (
  `id` int(4) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `resumo` varchar(10000) NOT NULL,
  `link` varchar(1000) NOT NULL,
  `pergunta` varchar(1000) NOT NULL,
  `resposta` varchar(10000) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_turma` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aulas`
--

INSERT INTO `aulas` (`id`, `titulo`, `resumo`, `link`, `pergunta`, `resposta`, `id_user`, `id_turma`) VALUES
(1, 'Matemática - Operações de soma com 2 parcelas', 'Para somar 2 números, basta adicionar a quantidade de um ao valor de outro', 'https://www.youtube.com/embed/HdbZqAXQm3o', 'Quanto é 1+1?', '2', '1', 1),
(2, 'Matemática - Operações de subtração com 2 parcelas', 'Para subtrair um numero, basta retirar a quantidade de unidades do primeiro no segundo numero', 'https://www.youtube.com/watch?v=cJl92_ytkz0', 'Quanto é 1 - 1?', '0', '1', 2),
(7, 'História do Brasil', 'Em 22 de Abril de 1500, Pedro alvares Cabral Descobriu o Brasil', 'krzOVoXGHHY', 'Quem descobriu o Brasil?', 'Pedro Alvares Cabral', '1', 1),
(8, 'História da frança', 'A França foi ...', 'https://www.youtube.com/watch?v=IMICN1ZN-ag', 'Qual nome da torre de Paris?', 'Eifell', '1', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

CREATE TABLE `turma` (
  `id` int(11) NOT NULL,
  `lim_alunos` int(11) NOT NULL,
  `dt_criacao` date NOT NULL,
  `dt_termino` date NOT NULL,
  `id_professor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `turma`
--

INSERT INTO `turma` (`id`, `lim_alunos`, `dt_criacao`, `dt_termino`, `id_professor`) VALUES
(1, 40, '2019-09-09', '2019-09-30', 1),
(2, 40, '2019-09-03', '2019-09-30', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `user` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nick` varchar(200) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `status` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `nick`, `tipo`, `status`) VALUES
(1, 'carlos.souza@unigranrio.br', '1234', 'carlos', 'professor', 1),
(2, 'aluno@unigranrio.br', '1234', 'aluno', 'aluno', 1),
(3, 'roberto.neto@unigranrio.br', '1234', 'Roberto', 'professor', 1),
(4, 'pedro.gastoldi@unigranrio.br', '1234', 'Pedro', 'professor', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administra`
--
ALTER TABLE `administra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assiste`
--
ALTER TABLE `assiste`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administra`
--
ALTER TABLE `administra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assiste`
--
ALTER TABLE `assiste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `turma`
--
ALTER TABLE `turma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
