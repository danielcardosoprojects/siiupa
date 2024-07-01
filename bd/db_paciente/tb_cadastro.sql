-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 27-Jun-2024 às 16:22
-- Versão do servidor: 10.4.10-MariaDB
-- versão do PHP: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_pacientes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cadastro`
--

DROP TABLE IF EXISTS `tb_cadastro`;
CREATE TABLE IF NOT EXISTS `tb_cadastro` (
  `id_paciente` int(10) NOT NULL AUTO_INCREMENT,
  `nomecompleto` varchar(255) CHARACTER SET latin1 NOT NULL,
  `nomedamae` varchar(255) CHARACTER SET latin1 NOT NULL,
  `idade` int(3) NOT NULL,
  `datadenascimento` date NOT NULL,
  `sexo` varchar(1) CHARACTER SET latin1 NOT NULL,
  `telefone1` varchar(16) CHARACTER SET latin1 NOT NULL,
  `telefone2` varchar(16) CHARACTER SET latin1 NOT NULL,
  `telefone3` varchar(16) CHARACTER SET latin1 NOT NULL,
  `telefone4` varchar(16) CHARACTER SET latin1 NOT NULL,
  `rg` varchar(11) CHARACTER SET latin1 NOT NULL,
  `cpf` varchar(11) CHARACTER SET latin1 NOT NULL,
  `cartaosus` int(100) NOT NULL,
  `responsavel` varchar(255) CHARACTER SET latin1 NOT NULL,
  `enderecoRua` varchar(255) CHARACTER SET latin1 NOT NULL,
  `enderecoNumero` int(7) NOT NULL,
  `enderecoPerimetro` varchar(255) CHARACTER SET latin1 NOT NULL,
  `enderecoBairro` varchar(100) CHARACTER SET latin1 NOT NULL,
  `municipio` varchar(100) CHARACTER SET latin1 NOT NULL,
  `UF` varchar(2) CHARACTER SET latin1 NOT NULL,
  `tipoacompanhante` varchar(60) CHARACTER SET latin1 NOT NULL,
  `veiopor` varchar(60) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_paciente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
