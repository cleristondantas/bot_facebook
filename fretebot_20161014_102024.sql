-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "dialogos_base" ----------------------------
CREATE TABLE `dialogos_base` (
	`id` Int( 255 ) AUTO_INCREMENT NOT NULL,
	`entrada` Text NOT NULL,
	`saida` Text NOT NULL,
	`tipo` Int( 255 ) NOT NULL,
	`variavel` Int( 2 ) NOT NULL DEFAULT '0',
	PRIMARY KEY ( `id` ) )
ENGINE = InnoDB
AUTO_INCREMENT = 20;
-- ---------------------------------------------------------


-- CREATE TABLE "interacoes" -------------------------------
CREATE TABLE `interacoes` (
	`id` Int( 255 ) AUTO_INCREMENT NOT NULL,
	`sender_id` BigInt( 255 ) NOT NULL,
	`mensagem` Text NOT NULL,
	`resposta` Text NOT NULL,
	`data_hora` Timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`json` Text NOT NULL,
	`tipo` Int( 255 ) NOT NULL,
	PRIMARY KEY ( `id` ),
	CONSTRAINT `unique_id` UNIQUE( `id` ) )
ENGINE = InnoDB
AUTO_INCREMENT = 99;
-- ---------------------------------------------------------


-- CREATE TABLE "usuarios" ---------------------------------
CREATE TABLE `usuarios` (
	`id` Int( 255 ) AUTO_INCREMENT NOT NULL,
	`sender_id` BigInt( 255 ) NOT NULL,
	`placa` VarChar( 255 ) NOT NULL,
	`cod_veiculo` Int( 255 ) NOT NULL,
	`nome` VarChar( 255 ) NOT NULL,
	PRIMARY KEY ( `id` ) )
ENGINE = InnoDB
AUTO_INCREMENT = 4;
-- ---------------------------------------------------------


-- Dump data of "dialogos_base" ----------------------------
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '1', 'oi', 'Olá', '1', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '2', 'ola', 'Olá', '1', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '3', 'oi', 'Oi', '1', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '4', 'oi', 'Oi, tudo bem?', '1', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '5', 'bom dia', 'Oi, Bom dia', '14', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '6', 'boa tarde', 'Olá, boa tarde meu jovem', '13', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '7', 'boa noite', 'Oi, boa noite meu fii', '12', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '8', 'ola', 'Oi', '1', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '9', 'fretes', 'Vocês está procurando fretes?', '2', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '10', 'aoo', 'trem bruto', '3', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '11', 'tchau', 'volte em breve', '4', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '12', 'meu fii', 'link e foto', '3', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '13', 'meu fi', 'link e foto', '3', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '16', 'oi', 'Oi #, tudo bem?', '1', '1' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '17', 'tudo', 'que bom meu querido, qual seu nome?', '22', '0' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '18', '', 'Não vou esquecer pedros.., ops! #', '6', '1' );
INSERT INTO `dialogos_base`(`id`,`entrada`,`saida`,`tipo`,`variavel`) VALUES ( '19', '', 'não entendi, estou aprendendo, ainda sou iniciante..', '5', '1' );
-- ---------------------------------------------------------
