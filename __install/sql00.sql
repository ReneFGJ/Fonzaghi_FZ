-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2014 at 05:31 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fz`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajax_cidade`
--

CREATE TABLE IF NOT EXISTS `ajax_cidade` (
  `id_cidade` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cidade_nome` char(40) DEFAULT NULL,
  `cidade_codigo` char(7) DEFAULT NULL,
  `cidade_ativo` int(11) DEFAULT '1',
  `cidade_use` char(7) DEFAULT NULL,
  `cidade_pais` char(7) DEFAULT NULL,
  `cidade_estado` char(7) DEFAULT NULL,
  `cidade_idioma` char(5) DEFAULT 'pt_BR',
  `cidade_sigla` char(3) DEFAULT NULL,
  UNIQUE KEY `id_cidade` (`id_cidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `ajax_cidade`
--

INSERT INTO `ajax_cidade` (`id_cidade`, `cidade_nome`, `cidade_codigo`, `cidade_ativo`, `cidade_use`, `cidade_pais`, `cidade_estado`, `cidade_idioma`, `cidade_sigla`) VALUES
(4, 'Curitiba', '0000002', 1, '', 'BRA', 'PR', 'pt_BR', 'CWB'),
(12, '0000 :: sem identificação ::', '0000027', 1, '', '', '', 'pt_BR', ''),
(27, 'Cascavel', '0000023', 1, '', '', '0000001', 'pt_BR', 'Cas'),
(37, 'São José dos Pinhais', '1000001', 1, NULL, 'BRA', 'PR', 'pt_BR', 'SJO'),
(38, 'Colombo', '1000002', 1, NULL, 'BRA', 'PR', 'pt_BR', NULL),
(39, 'Pinhais', '1000003', 1, NULL, 'BRA', 'PR', 'pt_BR', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cad_complemento`
--

CREATE TABLE IF NOT EXISTS `cad_complemento` (
  `id_cmp` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cmp_cliente` char(7) DEFAULT NULL,
  `cmp_cliente_seq` char(2) DEFAULT NULL,
  `cmp_salario` double DEFAULT NULL,
  `cmp_salario_complementar` double DEFAULT NULL,
  `cmp_estado_civil` char(1) DEFAULT NULL,
  `cmp_estado_civil_tempo` int(11) DEFAULT NULL,
  `cmp_profissao` char(100) DEFAULT NULL,
  `cmp_experiencia_vendas` int(11) DEFAULT NULL,
  `cmp_patrimonio` char(1) DEFAULT NULL,
  `cmp_imovel_tempo` int(11) DEFAULT NULL,
  `cmp_valor_aluguel` double DEFAULT NULL,
  `cmp_emprego_tempo` int(11) DEFAULT NULL,
  `cmp_propaganda` char(3) DEFAULT NULL,
  `cmp_propaganda2` char(3) DEFAULT NULL,
  `cmp_log` char(10) DEFAULT NULL,
  `cmp_data` int(11) DEFAULT NULL,
  `cmp_lastupdate_log` char(10) DEFAULT NULL,
  `cmp_lastupdate` int(11) DEFAULT NULL,
  `cmp_status` char(1) DEFAULT '1',
  PRIMARY KEY (`id_cmp`),
  UNIQUE KEY `id_cmp` (`id_cmp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cad_complemento`
--

INSERT INTO `cad_complemento` (`id_cmp`, `cmp_cliente`, `cmp_cliente_seq`, `cmp_salario`, `cmp_salario_complementar`, `cmp_estado_civil`, `cmp_estado_civil_tempo`, `cmp_profissao`, `cmp_experiencia_vendas`, `cmp_patrimonio`, `cmp_imovel_tempo`, `cmp_valor_aluguel`, `cmp_emprego_tempo`, `cmp_propaganda`, `cmp_propaganda2`, `cmp_log`, `cmp_data`, `cmp_lastupdate_log`, `cmp_lastupdate`, `cmp_status`) VALUES
(1, '7000034', '00', 1500, 0, 'S', 0, 'PROGRAMADOR', 5, '1', 15, 0, 1, '066', '006', '', 20140605, '20140616', 20140610, 'A'),
(2, '7000035', '00', 23, 1, 'S', 23, '23', 23, NULL, 23, 23, NULL, '0', '4', 'RENE', 20140609, 'RENE', 20140609, 'A'),
(3, '7000038', '00', 1000, 1000, 'C', 5, 'FINANCEIRO', 10, NULL, 5, 500, NULL, '0', '1', 'WILLIAN', 20140611, 'WILLIAN', 20140611, 'A'),
(4, '7000039', '00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'WILLIAN', 20140613, NULL, NULL, 'A'),
(6, '7000037', '00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'WILLIAN', 20140618, NULL, NULL, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `cad_contato`
--

CREATE TABLE IF NOT EXISTS `cad_contato` (
  `id_con` int(11) NOT NULL AUTO_INCREMENT,
  `con_cliente` char(7) NOT NULL,
  `con_ddd` varchar(3) DEFAULT NULL,
  `con_numero` varchar(9) DEFAULT NULL,
  `con_log` varchar(15) DEFAULT NULL,
  `con_data` int(11) DEFAULT NULL,
  `con_lastupdate_log` varchar(15) DEFAULT NULL,
  `con_lastupdate` int(11) DEFAULT NULL,
  `con_lastcall` int(11) DEFAULT NULL,
  `con_observacao` text,
  `con_status` varchar(1) DEFAULT '@',
  PRIMARY KEY (`id_con`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabelas de consultoras a serem abordadas.' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cad_contato`
--

INSERT INTO `cad_contato` (`id_con`, `con_cliente`, `con_ddd`, `con_numero`, `con_log`, `con_data`, `con_lastupdate_log`, `con_lastupdate`, `con_lastcall`, `con_observacao`, `con_status`) VALUES
(1, '7000034', '041', '33647781', 'WILLIAN', 20140522, 'WILLIAN', 20140604, NULL, 'TESTE', '@'),
(2, '7000034', '042', '33647791', 'LAYNES', 20140521, 'WILLIAN', 20140604, NULL, 'TESTE2\n', '@'),
(3, '7000034', '043', NULL, NULL, NULL, 'WILLIAN', 20140604, NULL, NULL, '@');

-- --------------------------------------------------------

--
-- Table structure for table `cad_endereco`
--

CREATE TABLE IF NOT EXISTS `cad_endereco` (
  `id_end` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `end_cliente` char(7) DEFAULT NULL,
  `end_rua` char(100) DEFAULT NULL,
  `end_numero` char(10) DEFAULT NULL,
  `end_bairro` char(30) DEFAULT NULL,
  `end_cidade` char(30) DEFAULT NULL,
  `end_estado` char(2) DEFAULT NULL,
  `end_cep` char(8) DEFAULT NULL,
  `end_latitude` char(20) DEFAULT NULL,
  `end_longitude` char(20) DEFAULT NULL,
  `end_complemento` char(30) DEFAULT NULL,
  `end_status` char(1) DEFAULT NULL,
  `end_data` int(11) NOT NULL,
  `end_validado` int(11) NOT NULL,
  PRIMARY KEY (`id_end`),
  UNIQUE KEY `id_end` (`id_end`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cad_endereco`
--

INSERT INTO `cad_endereco` (`id_end`, `end_cliente`, `end_rua`, `end_numero`, `end_bairro`, `end_cidade`, `end_estado`, `end_cep`, `end_latitude`, `end_longitude`, `end_complemento`, `end_status`, `end_data`, `end_validado`) VALUES
(1, '7000035', 'Rua Padre Agostinho', '2885', 'Bigorrilho', 'CURITIBA', 'PR', '80710000', '0', '0', 'ap.1203', '1', 20140824, 0),
(3, '7000034', 'Rua Ebano Pereira', '60', 'Centro', 'CURITIBA', 'PR', '80710000', '0', '0', 'cj. 2101', '1', 20140825, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cad_pessoa`
--

CREATE TABLE IF NOT EXISTS `cad_pessoa` (
  `id_pes` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pes_cliente` char(7) DEFAULT NULL,
  `pes_cliente_seq` char(2) DEFAULT '00',
  `pes_nome` char(100) DEFAULT NULL,
  `pes_cpf` char(11) DEFAULT NULL,
  `pes_rg` char(15) DEFAULT NULL,
  `pes_nasc` int(11) DEFAULT NULL,
  `pes_naturalidade` char(30) DEFAULT NULL,
  `pes_genero` char(1) DEFAULT NULL,
  `pes_pai` char(100) DEFAULT NULL,
  `pes_mae` char(100) DEFAULT NULL,
  `pes_avalista` char(1) DEFAULT 'P',
  `pes_avalista_cod` char(7) DEFAULT NULL,
  `pes_data` int(11) DEFAULT NULL,
  `pes_log` varchar(15) NOT NULL,
  `pes_lastupdate` int(11) DEFAULT NULL,
  `pes_lastupdate_log` varchar(15) NOT NULL,
  `pes_mostruario` int(1) DEFAULT '0' COMMENT '1 já pegou mostruario 0 nunca pegou',
  `pes_status` char(1) DEFAULT '@',
  PRIMARY KEY (`id_pes`),
  UNIQUE KEY `id_pes` (`id_pes`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `cad_pessoa`
--

INSERT INTO `cad_pessoa` (`id_pes`, `pes_cliente`, `pes_cliente_seq`, `pes_nome`, `pes_cpf`, `pes_rg`, `pes_nasc`, `pes_naturalidade`, `pes_genero`, `pes_pai`, `pes_mae`, `pes_avalista`, `pes_avalista_cod`, `pes_data`, `pes_log`, `pes_lastupdate`, `pes_lastupdate_log`, `pes_mostruario`, `pes_status`) VALUES
(34, '7000034', '00', 'WILLIAN FELLIPE LAYNES', '04389871951', '0000000000', 19841214, 'BRASILEIRO', 'M', 'SIDENEI LAYNES', 'ROSANE LUCIA LAYNES', 'N', '0000034', 20140521, '', 20140805, 'WILLIAN', 0, '@'),
(35, '7000035', '00', 'RENE FAUSTINO GABRIEL JUNIOR', '72952105987', '3.825.355-7', 19691005, 'brasileiro', 'M', 'RENE FAUSTINO GABRIEL', 'DIVANIR GABRIEL', 'N', '0000000', 20140526, '', 20140731, 'RENE', 0, 'A'),
(37, '7000037', '00', 'MARINA SIQUEIRA TAVERNA', '05963964903', '1.080.579-5', 19920628, 'curitiba', 'F', 'snasnaisn', 'MARCIA DOS SANTOS SIQUEIRA', 'S', '15326', 20140528, '', 20140618, 'TAV', 0, '@'),
(38, '7000038', '00', 'CLAUDIA TKACZ', '03367922986', '0.000.000-0', 19821119, 'CURITIBA', 'F', 'SR TKACZ', 'OLGA TKACZ', 'N', '38', 20140611, 'WILLIAN', 20140611, 'WILLIAN', 0, '@'),
(39, '7000039', '00', 'ANTONIO AUGUSTO TEODORO DA SILVA', '03837061906', NULL, 19820310, NULL, NULL, NULL, 'PAULINA DA SILVA', 'P', NULL, 20140613, 'WILLIAN', NULL, '', 0, '@');

-- --------------------------------------------------------

--
-- Table structure for table `cad_pessoa_log`
--

CREATE TABLE IF NOT EXISTS `cad_pessoa_log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `log_cliente` varchar(7) DEFAULT NULL COMMENT 'Código do cliente',
  `log_data` int(11) DEFAULT NULL COMMENT 'Data de lançamento',
  `log_login` varchar(15) DEFAULT NULL COMMENT 'Login de quem efetuou o registro.',
  `log_acao` varchar(100) DEFAULT NULL COMMENT 'Descrição da ação realizada.',
  `log_status_registro` varchar(1) DEFAULT NULL COMMENT 'Status do lançamento que gerou o registro.(@,A,T,C,R)',
  `log_status` int(1) DEFAULT '1' COMMENT 'Ativo- 1 ou inativo - 0',
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cad_referencia`
--

CREATE TABLE IF NOT EXISTS `cad_referencia` (
  `id_ref` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ref_cliente` char(7) DEFAULT NULL,
  `ref_cliente_seq` char(2) DEFAULT NULL,
  `ref_nome` char(30) DEFAULT NULL,
  `ref_cep` char(8) DEFAULT NULL,
  `ref_observacao` text,
  `ref_data` int(11) DEFAULT NULL,
  `ref_grau` char(2) DEFAULT NULL,
  `ref_status` char(1) DEFAULT '@',
  `ref_ativo` char(1) DEFAULT '1',
  `ref_validado` int(11) NOT NULL,
  `ref_ddd` char(3) NOT NULL,
  `ref_numero` char(10) NOT NULL,
  PRIMARY KEY (`id_ref`),
  UNIQUE KEY `id_ref` (`id_ref`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `cad_referencia`
--

INSERT INTO `cad_referencia` (`id_ref`, `ref_cliente`, `ref_cliente_seq`, `ref_nome`, `ref_cep`, `ref_observacao`, `ref_data`, `ref_grau`, `ref_status`, `ref_ativo`, `ref_validado`, `ref_ddd`, `ref_numero`) VALUES
(1, '7000034', '02', 'RENE FAUSTINO', '82000150', 'CONSULTOR ANALISTA DA TI', 20140616, NULL, 'A', '1', 0, '', ''),
(2, '7000034', '01', 'AMIGO DO WILLIAN', '82410150', 'É AMIGO DO WILLIAN', 20140616, NULL, 'A', '1', 0, '', ''),
(3, '7000035', NULL, 'VIVIANE TULIO', '', 'ESPOSA', 20140824, '0', '1', '1', 0, '41', '88666389'),
(4, '7000035', NULL, 'DIVANIR GABRIEL', '', '', 20140824, '06', '1', '1', 0, '41', '30190722'),
(5, '7000035', NULL, 'André Vitor Gabriel', '', '', 20140824, '08', '1', '1', 0, '41', '88033883'),
(6, '7000035', NULL, 'MARIA ANGELA', '', 'Conta corrente desde 1996.', 20140824, '03', '1', '1', 0, '41', '3012.2000'),
(7, '7000034', NULL, 'RAFAEL MIRLACHI', '', 'AMIGO DE TRABALHO', 20140825, '01', '1', '1', 0, '41', '30222253');

-- --------------------------------------------------------

--
-- Table structure for table `cad_referencia_tipo`
--

CREATE TABLE IF NOT EXISTS `cad_referencia_tipo` (
  `id_ret` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ret_codigo` char(7) NOT NULL DEFAULT '',
  `ret_nome` char(30) DEFAULT NULL,
  `ret_status` char(1) DEFAULT NULL,
  `ret_peso` int(11) NOT NULL,
  `ret_tipo` char(1) NOT NULL,
  PRIMARY KEY (`ret_codigo`),
  UNIQUE KEY `id_ret` (`id_ret`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `cad_referencia_tipo`
--

INSERT INTO `cad_referencia_tipo` (`id_ret`, `ret_codigo`, `ret_nome`, `ret_status`, `ret_peso`, `ret_tipo`) VALUES
(1, '00', 'Tio/Tia', '1', 0, ''),
(2, '01', 'Amigo', '1', 0, ''),
(3, '02', 'Avó/Avô', '1', 0, ''),
(4, '03', 'Gerente do Banco', '1', 0, 'C'),
(5, '04', 'Sobrinho/Sobrinha', '1', 0, ''),
(7, '05', 'Vizinho', '1', 0, ''),
(8, '06', 'Pai/Mãe', '1', 0, ''),
(9, '07', 'Marido/Esposa', '1', 0, ''),
(10, '08', 'Filho/Filha', '1', 0, ''),
(11, '09', 'Cunhado/Cunhada', '1', 0, ''),
(12, '10', 'Loja Concorrente', '1', 0, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `cad_telefone`
--

CREATE TABLE IF NOT EXISTS `cad_telefone` (
  `id_tel` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tel_cliente` char(7) DEFAULT NULL,
  `tel_cliente_seq` char(2) DEFAULT NULL,
  `tel_ddd` char(3) DEFAULT NULL,
  `tel_numero` char(9) DEFAULT NULL,
  `tel_tipo` char(1) DEFAULT NULL,
  `tel_data` int(11) DEFAULT '0',
  `tel_validado` char(1) DEFAULT NULL,
  `tel_status` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_tel`),
  UNIQUE KEY `id_tel` (`id_tel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cad_telefone`
--

INSERT INTO `cad_telefone` (`id_tel`, `tel_cliente`, `tel_cliente_seq`, `tel_ddd`, `tel_numero`, `tel_tipo`, `tel_data`, `tel_validado`, `tel_status`) VALUES
(1, '7000034', '01', '41', '66666666', 'R', 20140616, '9', '1'),
(2, '7000034', '02', '41', '96969696', 'C', 20140616, '1', '1'),
(3, '7000034', '00', '41', '30222253', 'C', 20140824, '0', '1'),
(4, '7000034', '00', '41', '30218332', 'C', 20140824, '0', '1'),
(5, '7000035', '00', '41', '88119061', 'R', 20140824, '0', '1'),
(6, '7000035', '00', '41', '30222253', 'C', 20140824, '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `propagandas`
--

CREATE TABLE IF NOT EXISTS `propagandas` (
  `id_prop` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prop_codigo` char(3) DEFAULT NULL,
  `prop_descricao` char(50) DEFAULT NULL,
  `prop_ativo` char(1) DEFAULT NULL,
  `prop_ativo_1` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_prop`),
  UNIQUE KEY `id_prop` (`id_prop`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `propagandas`
--

INSERT INTO `propagandas` (`id_prop`, `prop_codigo`, `prop_descricao`, `prop_ativo`, `prop_ativo_1`) VALUES
(1, '012', 'RADIO - CAIOBA A NOITE', 'S', 1),
(2, '006', 'RADIO - BANDA B', 'S', 1),
(3, '021', 'RETORNO', 'S', 1),
(4, '027', 'INDICAÇÃO FUNCIONÁRIO', 'S', 1),
(5, '030', 'TV - REGIS CAMPOS', 'N', 0),
(6, '041', 'OUTROS', 'S', 1),
(7, '059', 'TELELISTA', 'S', 1),
(8, '060', 'TELEMARKET', 'S', 1),
(9, '015', 'RADIO - 98 FM', 'S', 1),
(10, '002', 'RADIO - CAIOBA', 'S', 1),
(11, '061', 'TELEMARKET OPERADORA', 'S', 1),
(12, '032', 'ANG 4', 'S', 1),
(13, '016', 'TV+', 'S', 1),
(14, '004', 'RADIO CLUBE', 'S', 1),
(15, '082', 'SBT', 'S', 1),
(16, '066', 'EQ. AMARELA', 'S', 1),
(17, '067', 'EQ. AZUL', 'S', 1),
(18, '068', 'EQ. ROSA', 'S', 1),
(19, '069', 'EQ. VERDE', 'S', 1),
(20, '081', 'SUPERVISÃO DE ANGARIAÇÃO', 'S', 1),
(21, '008', 'INDICAÇÃO', 'S', 1),
(22, '080', 'ANGARIAÇÃO GERAL', 'S', 1),
(23, '600', '600 - Angariador (Robson)', 'S', 1),
(24, '602', '602 - Angariador (Adriana)', 'S', 1),
(25, '603', '603 - Angariador (Daiana)', 'S', 1),
(26, '604', '604 - Angariador (Cintia)', 'S', 1),
(27, '062', '062 - Angariação', 'S', 1),
(28, '064', 'TRIBUNA', 'S', 1),
(29, '065', 'ESTADO DO PARANÁ', 'S', 1),
(30, '063', 'GAZETA DO POVO', 'S', 1),
(31, 'XXX', 'XXX - Angariação', 'N', 0),
(32, '018', 'Angariação SHIRLEY', 'S', 1),
(33, '500', 'Central Mobile', 'S', 1),
(34, '100', 'Internet - Facebook', 'S', 1),
(35, '101', 'Internet - Site Fonzaghi', 'S', 1),
(36, '102', 'Mailing Outras', 'S', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_us` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `us_nomecompleto` char(100) NOT NULL,
  `us_login` char(20) NOT NULL,
  `us_nivel` int(11) NOT NULL,
  `us_level` int(11) NOT NULL,
  `us_cracha` char(8) NOT NULL,
  `us_perfil` text NOT NULL,
  `us_senha` char(30) NOT NULL,
  `us_status` char(1) NOT NULL,
  UNIQUE KEY `id_us` (`id_us`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_us`, `us_nomecompleto`, `us_login`, `us_nivel`, `us_level`, `us_cracha`, `us_perfil`, `us_senha`, `us_status`) VALUES
(1, 'RENE FAUSTINO GABRIEL JUNIOR', 'RENE', 9, 9, '00001', '', '1111', 'A');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
