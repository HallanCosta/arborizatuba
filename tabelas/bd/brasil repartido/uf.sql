-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 23-Ago-2019 às 22:40
-- Versão do servidor: 5.7.23
-- versão do PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brasil`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `uf`
--

DROP TABLE IF EXISTS `uf`;
CREATE TABLE IF NOT EXISTS `uf` (
  `UF` char(2) NOT NULL DEFAULT '',
  `Nome` varchar(72) NOT NULL DEFAULT '',
  `Cep1` varchar(5) NOT NULL DEFAULT '',
  `Cep2` varchar(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`UF`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `uf`
--

INSERT INTO `uf` (`UF`, `Nome`, `Cep1`, `Cep2`) VALUES
('AC', 'Acre', '69900', '69999'),
('AL', 'Alagoas', '57000', '57999'),
('AM', 'Amazonas', '69000', '69299'),
('AP', 'Amapá', '68900', '68999'),
('BA', 'Bahia', '40000', '48999'),
('CE', 'Ceará', '60000', '63999'),
('DF', 'Distrito Federal', '70000', '72799'),
('ES', 'Espírito Santo', '29000', '29999'),
('GO', 'Goiás', '72800', '72999'),
('MA', 'Maranhão', '65000', '65999'),
('MG', 'Minas Gerais', '30000', '39999'),
('MS', 'Mato Grosso do Sul', '79000', '79999'),
('MT', 'Mato Grosso', '78000', '78899'),
('PA', 'Pará', '66000', '68899'),
('PB', 'Paraíba', '58000', '58999'),
('PE', 'Pernambuco', '50000', '56999'),
('PI', 'Piauí', '64000', '64999'),
('PR', 'Paraná', '80000', '87999'),
('RJ', 'Rio de Janeiro', '20000', '28999'),
('RN', 'Rio Grande do Norte', '59000', '59999'),
('RO', 'Rondônia', '78900', '78999'),
('RR', 'Roraima', '69300', '69399'),
('RS', 'Rio Grande do Sul', '90000', '99999'),
('SC', 'Santa Catarina', '88000', '89999'),
('SE', 'Sergipe', '49000', '49999'),
('SP', 'São Paulo', '01000', '19999'),
('TO', 'Tocantins', '77000', '77999');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
