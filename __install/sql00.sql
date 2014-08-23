-- phpMyAdmin SQL Dump
-- version 4.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 23, 2014 at 03:29 PM
-- Server version: 5.5.27-log
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `FGHI`
--

-- --------------------------------------------------------

--
-- Table structure for table `cad_pessoa`
--

CREATE TABLE IF NOT EXISTS `cad_pessoa` (
`id_pes` bigint(20) unsigned NOT NULL,
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
  `pes_status` char(1) DEFAULT '@'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `cad_pessoa`
--

INSERT INTO `cad_pessoa` (`id_pes`, `pes_cliente`, `pes_cliente_seq`, `pes_nome`, `pes_cpf`, `pes_rg`, `pes_nasc`, `pes_naturalidade`, `pes_genero`, `pes_pai`, `pes_mae`, `pes_avalista`, `pes_avalista_cod`, `pes_data`, `pes_log`, `pes_lastupdate`, `pes_lastupdate_log`, `pes_mostruario`, `pes_status`) VALUES
(34, '7000034', '00', 'WILLIAN FELLIPE LAYNES', '04389871951', '9.999.999-9', 19841214, 'BRASILEIRO', 'M', 'SIDENEI LAYNES', 'ROSANE LUCIA LAYNES', 'N', '0000034', 20140521, '', 20140805, 'WILLIAN', 0, '@'),
(35, '7000035', '00', 'RENE FAUSTINO GABRIEL JUNIOR', '72952105987', '3.825.355-7', 19691005, 'brasileiro', 'M', 'RENE FAUSTINO GABRIEL', 'DIVANIR GABRIEL', 'N', '0000000', 20140526, '', 20140731, 'RENE', 0, 'A'),
(37, '7000037', '00', 'MARINA SIQUEIRA TAVERNA', '05963964903', '1.080.579-5', 19920628, 'curitiba', 'F', 'snasnaisn', 'MARCIA DOS SANTOS SIQUEIRA', 'S', '15326', 20140528, '', 20140618, 'TAV', 0, '@'),
(38, '7000038', '00', 'CLAUDIA TKACZ', '03367922986', '0.000.000-0', 19821119, 'CURITIBA', 'F', 'SR TKACZ', 'OLGA TKACZ', 'N', '38', 20140611, 'WILLIAN', 20140611, 'WILLIAN', 0, '@'),
(39, '7000039', '00', 'ANTONIO AUGUSTO TEODORO DA SILVA', '03837061906', NULL, 19820310, NULL, NULL, NULL, 'PAULINA DA SILVA', 'P', NULL, 20140613, 'WILLIAN', NULL, '', 0, '@');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cad_pessoa`
--
ALTER TABLE `cad_pessoa`
 ADD PRIMARY KEY (`id_pes`), ADD UNIQUE KEY `id_pes` (`id_pes`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cad_pessoa`
--
ALTER TABLE `cad_pessoa`
MODIFY `id_pes` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
