-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 24-Jul-2014 às 03:32
-- Versão do servidor: 5.6.12-log
-- versão do PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `db_pacientes`
--
CREATE DATABASE IF NOT EXISTS `db_pacientes` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_pacientes`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cadastro`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `tb_cadastro`
--

INSERT INTO `tb_cadastro` (`id_paciente`, `nomecompleto`, `nomedamae`, `idade`, `datadenascimento`, `sexo`, `telefone1`, `telefone2`, `telefone3`, `telefone4`, `rg`, `cpf`, `cartaosus`, `responsavel`, `enderecoRua`, `enderecoNumero`, `enderecoPerimetro`, `enderecoBairro`, `municipio`, `UF`, `tipoacompanhante`, `veiopor`) VALUES
(1, 'Daniel Cardoso de Oliveira', 'Maria Zuleide Cardoso de Oliveira', 22, '1991-12-13', 'm', '(91) 3721-1661', '(91) 8288-2022', '(91) 8878-7695', '', '6344196', '012.642.102', 2147483647, 'Ti Toin', 'Al Dr BraganÃ§a', 3560, 'Casa', 'CaiÃ§ara', 'Castanhal', '', 'NÃ£o acompanhado', 'AmbulÃ¢ncia - SAMU'),
(2, '', '', 0, '0000-00-00', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(3, 'Romualdo Moura', '', 0, '0000-00-00', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(4, 'Julio de Rimet', 'Maria Onize Odete Odeita', 32, '1955-12-31', 'm', '(91) 4564-6545', '(91) 5464-6546', '(91) 5456-4646', '', '56565656', '565.656.565', 5464564, 'Tal Pessoa', 'Rua tal', 0, 'Complemento tal', 'Bairro Tal', 'Cidade tal', '', 'Familiar', 'Meios prÃ³prios');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_farmacia`
--

CREATE TABLE IF NOT EXISTS `tb_farmacia` (
  `id_medicamento` int(11) NOT NULL,
  `medicamento_titulo` varchar(255) NOT NULL,
  `medicamento_tipoarmazenamento` varchar(255) NOT NULL,
  `medicamento_categoria` varchar(255) NOT NULL,
  `medicamento_subcategoria` varchar(255) NOT NULL,
  `medicamento_quantidade` varchar(255) NOT NULL,
  `medicamento_datavencimento` date NOT NULL,
  `medicamento_datacadastro` date NOT NULL,
  PRIMARY KEY (`id_medicamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_farmacia_historico`
--

CREATE TABLE IF NOT EXISTS `tb_farmacia_historico` (
  `id_farmaciahistorico` int(11) NOT NULL,
  `farmaciahistorico_idmedicamento` int(11) NOT NULL,
  `farmaciahistorico_quantidade` int(11) NOT NULL,
  `farmaciahistorico_acao` varchar(255) NOT NULL,
  `farmaciamedicamento_localdestino` varchar(255) NOT NULL,
  `farmaciahistorico_data` date NOT NULL,
  `farmaciahistorico_lote` varchar(255) NOT NULL,
  `farmaciahistorico_datavencimento` date NOT NULL,
  PRIMARY KEY (`id_farmaciahistorico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
