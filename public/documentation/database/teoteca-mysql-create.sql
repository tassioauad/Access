SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `teoteca` ;
CREATE SCHEMA IF NOT EXISTS `teoteca` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `teoteca` ;

-- -----------------------------------------------------
-- Table `teoteca`.`permissao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`permissao` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`permissao` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tag` VARCHAR(10) NULL ,
  `descricao` VARCHAR(45) NULL ,
  `data_criacao` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `hora_criacao` TIME NOT NULL DEFAULT CURRENT_TIME ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`grupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`grupo` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`grupo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tag` VARCHAR(10) NOT NULL COMMENT '	' ,
  `descricao` VARCHAR(45) NOT NULL ,
  `data_criacao` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `hora_criacao` TIME NOT NULL DEFAULT CURRENT_TIME ,
  `ativo` TINYINT(1) NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `tag_UNIQUE` (`tag` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`grupo_permissao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`grupo_permissao` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`grupo_permissao` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `permissao_id` INT NOT NULL ,
  `grupo_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_grupo_permissao_permissao1_idx` (`permissao_id` ASC) ,
  INDEX `fk_grupo_permissao_grupo1_idx` (`grupo_id` ASC) ,
  CONSTRAINT `fk_grupo_permissao_permissao1`
    FOREIGN KEY (`permissao_id` )
    REFERENCES `teoteca`.`permissao` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_permissao_grupo1`
    FOREIGN KEY (`grupo_id` )
    REFERENCES `teoteca`.`grupo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`doutrina`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`doutrina` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`doutrina` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL ,
  `descricao` TEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`usuario` (
  `id` INT NOT NULL ,
  `tag` VARCHAR(10) NOT NULL ,
  `nome_completo` VARCHAR(45) NOT NULL DEFAULT '/images/usuario_foto/foto_default.gif' ,
  `src_imagem` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `login` VARCHAR(20) NOT NULL ,
  `senha` TEXT NOT NULL ,
  `doutrina_id` INT NOT NULL ,
  `data_nascimento` VARCHAR(45) NULL ,
  `endereco_cidade` VARCHAR(45) NULL ,
  `endereco_bairro` VARCHAR(45) NULL ,
  `endereco_rua` VARCHAR(45) NULL ,
  `endereco_numero` VARCHAR(45) NULL ,
  `endereco_complemento` VARCHAR(45) NULL ,
  `cep` VARCHAR(10) NULL ,
  `telefone` VARCHAR(9) NULL ,
  `igreja` VARCHAR(45) NULL ,
  `data_criacao` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `hora_criacao` TIME NOT NULL DEFAULT CURRENT_TIME ,
  `chave_ativacao` VARCHAR(8) NOT NULL ,
  `ativo` TINYINT(1) NOT NULL DEFAULT FALSE ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `tag_UNIQUE` (`tag` ASC) ,
  INDEX `fk_usuario_doutrina2_idx` (`doutrina_id` ASC) ,
  CONSTRAINT `fk_usuario_doutrina2`
    FOREIGN KEY (`doutrina_id` )
    REFERENCES `teoteca`.`doutrina` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`usuario` (
  `id` INT NOT NULL ,
  `tag` VARCHAR(10) NOT NULL ,
  `nome_completo` VARCHAR(45) NOT NULL DEFAULT '/images/usuario_foto/foto_default.gif' ,
  `src_imagem` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `login` VARCHAR(20) NOT NULL ,
  `senha` TEXT NOT NULL ,
  `doutrina_id` INT NOT NULL ,
  `data_nascimento` VARCHAR(45) NULL ,
  `endereco_cidade` VARCHAR(45) NULL ,
  `endereco_bairro` VARCHAR(45) NULL ,
  `endereco_rua` VARCHAR(45) NULL ,
  `endereco_numero` VARCHAR(45) NULL ,
  `endereco_complemento` VARCHAR(45) NULL ,
  `cep` VARCHAR(10) NULL ,
  `telefone` VARCHAR(9) NULL ,
  `igreja` VARCHAR(45) NULL ,
  `data_criacao` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `hora_criacao` TIME NOT NULL DEFAULT CURRENT_TIME ,
  `chave_ativacao` VARCHAR(8) NOT NULL ,
  `ativo` TINYINT(1) NOT NULL DEFAULT FALSE ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `tag_UNIQUE` (`tag` ASC) ,
  INDEX `fk_usuario_doutrina2_idx` (`doutrina_id` ASC) ,
  CONSTRAINT `fk_usuario_doutrina2`
    FOREIGN KEY (`doutrina_id` )
    REFERENCES `teoteca`.`doutrina` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`usuario_grupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`usuario_grupo` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`usuario_grupo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `grupo_permissao_id` INT NOT NULL ,
  `usuario_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_usuario_grupo_grupo_permissao1_idx` (`grupo_permissao_id` ASC) ,
  INDEX `fk_usuario_grupo_usuario1_idx` (`usuario_id` ASC) ,
  CONSTRAINT `fk_usuario_grupo_grupo_permissao1`
    FOREIGN KEY (`grupo_permissao_id` )
    REFERENCES `teoteca`.`grupo_permissao` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_grupo_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `teoteca`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`publicacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`publicacao` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`publicacao` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `usuario_id` INT NOT NULL ,
  `tag` VARCHAR(45) NOT NULL ,
  `titulo` VARCHAR(45) NULL ,
  `chamada` VARCHAR(255) NULL ,
  `texto` TEXT NULL ,
  `data_publicacao` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `ativo` TINYINT(1) NULL DEFAULT TRUE ,
  `hora_publicacao` TIME NOT NULL DEFAULT CURRENT_TIME ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_publicacao_usuario1_idx` (`usuario_id` ASC) ,
  UNIQUE INDEX `tag_UNIQUE` (`tag` ASC) ,
  CONSTRAINT `fk_publicacao_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `teoteca`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`publicacao_classificacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`publicacao_classificacao` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`publicacao_classificacao` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `publicacao_id` INT NOT NULL ,
  `voto` SMALLINT(6) NOT NULL ,
  `data_classificacao` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `hora_classificacao` TIME NOT NULL DEFAULT CURRENT_TIME ,
  `ativa` TINYINT(1) NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_publicacao_classificacao_publicacao1_idx` (`publicacao_id` ASC) ,
  CONSTRAINT `fk_publicacao_classificacao_publicacao1`
    FOREIGN KEY (`publicacao_id` )
    REFERENCES `teoteca`.`publicacao` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`referencia_publicacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`referencia_publicacao` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`referencia_publicacao` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `publicacao_id` INT NOT NULL ,
  `publicacao_referencia_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_referencia_publicacao_publicacao1_idx` (`publicacao_id` ASC) ,
  INDEX `fk_referencia_publicacao_publicacao2_idx` (`publicacao_referencia_id` ASC) ,
  CONSTRAINT `fk_referencia_publicacao_publicacao1`
    FOREIGN KEY (`publicacao_id` )
    REFERENCES `teoteca`.`publicacao` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_referencia_publicacao_publicacao2`
    FOREIGN KEY (`publicacao_referencia_id` )
    REFERENCES `teoteca`.`publicacao` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`notificacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`notificacao` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`notificacao` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `usuario_id` INT NOT NULL ,
  `usuario_destinatario_id` INT NOT NULL ,
  `titulo` VARCHAR(45) NOT NULL ,
  `texto` TEXT NOT NULL ,
  `data_notificacao` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `hora_notificacao` TIME NOT NULL DEFAULT 'CURRENT_TIME' ,
  `lida` TINYINT(1) NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_notificacao_usuario1_idx` (`usuario_id` ASC) ,
  INDEX `fk_notificacao_usuario2_idx` (`usuario_destinatario_id` ASC) ,
  CONSTRAINT `fk_notificacao_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `teoteca`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_notificacao_usuario2`
    FOREIGN KEY (`usuario_destinatario_id` )
    REFERENCES `teoteca`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`historico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`historico` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`historico` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `acao` VARCHAR(100) NOT NULL ,
  `data_acao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `usuario_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_historico_usuario1_idx` (`usuario_id` ASC) ,
  CONSTRAINT `fk_historico_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `teoteca`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`troca_senha`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`troca_senha` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`troca_senha` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `usuario_id` INT NOT NULL ,
  `chave_permissao` VARCHAR(8) NOT NULL ,
  `data_solicitacao` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `hora_solicitacao` TIME NOT NULL DEFAULT CURRENT_TIME ,
  `ativa` TINYINT(1) NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_troca_senha_usuario1_idx` (`usuario_id` ASC) ,
  CONSTRAINT `fk_troca_senha_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `teoteca`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`publicacao_denuncia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`publicacao_denuncia` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`publicacao_denuncia` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `publicacao_id` INT NOT NULL ,
  `usuario_id` INT NOT NULL ,
  `motivo` TEXT NOT NULL ,
  `data_publicacao` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `hora_publicacao` TIME NOT NULL DEFAULT CURRENT_TIME ,
  `ativa` VARCHAR(45) NOT NULL DEFAULT 'TRUE' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_publicacao_denuncia_publicacao1_idx` (`publicacao_id` ASC) ,
  INDEX `fk_publicacao_denuncia_usuario1_idx` (`usuario_id` ASC) ,
  CONSTRAINT `fk_publicacao_denuncia_publicacao1`
    FOREIGN KEY (`publicacao_id` )
    REFERENCES `teoteca`.`publicacao` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_publicacao_denuncia_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `teoteca`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`comentario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`comentario` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`comentario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `publicacao_id` INT NOT NULL ,
  `comentario` VARCHAR(255) NOT NULL ,
  `data_comentario` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `hora_comentario` TIME NOT NULL DEFAULT CURRENT_TIME ,
  `ativo` TINYINT(1) NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_comentario_publicacao1_idx` (`publicacao_id` ASC) ,
  CONSTRAINT `fk_comentario_publicacao1`
    FOREIGN KEY (`publicacao_id` )
    REFERENCES `teoteca`.`publicacao` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`testamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`testamento` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`testamento` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`livro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`livro` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`livro` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `testamento_id` INT NOT NULL ,
  `posicao` INT NOT NULL ,
  `nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_livro_testamento1_idx` (`testamento_id` ASC) ,
  CONSTRAINT `fk_livro_testamento1`
    FOREIGN KEY (`testamento_id` )
    REFERENCES `teoteca`.`testamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`versao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`versao` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`versao` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`versiculo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`versiculo` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`versiculo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `livro_id` INT NOT NULL ,
  `versao_id` INT NOT NULL ,
  `capitulo` INT NOT NULL ,
  `versiculo` INT NOT NULL ,
  `texto` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_versiculo_livro1_idx` (`livro_id` ASC) ,
  INDEX `fk_versiculo_versao1_idx` (`versao_id` ASC) ,
  CONSTRAINT `fk_versiculo_livro1`
    FOREIGN KEY (`livro_id` )
    REFERENCES `teoteca`.`livro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_versiculo_versao1`
    FOREIGN KEY (`versao_id` )
    REFERENCES `teoteca`.`versao` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`referencia_versiculo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`referencia_versiculo` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`referencia_versiculo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `versiculo_id` INT NOT NULL ,
  `publicacao_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_referencia_versiculo_versiculo1_idx` (`versiculo_id` ASC) ,
  INDEX `fk_referencia_versiculo_publicacao1_idx` (`publicacao_id` ASC) ,
  CONSTRAINT `fk_referencia_versiculo_versiculo1`
    FOREIGN KEY (`versiculo_id` )
    REFERENCES `teoteca`.`versiculo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_referencia_versiculo_publicacao1`
    FOREIGN KEY (`publicacao_id` )
    REFERENCES `teoteca`.`publicacao` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teoteca`.`comentario_denuncia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teoteca`.`comentario_denuncia` ;

CREATE  TABLE IF NOT EXISTS `teoteca`.`comentario_denuncia` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `publicacao_denuncia_id` INT NOT NULL ,
  `comentario_id` INT NOT NULL ,
  `motivo` TEXT NOT NULL ,
  `data_denuncia` DATE NOT NULL DEFAULT CURRENT_DATE ,
  `ativa` TINYINT(1) NOT NULL DEFAULT TRUE ,
  `hora_denuncia` TIME NOT NULL DEFAULT CURRENT_TIME ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_denuncia_comentario_publicacao_denuncia1_idx` (`publicacao_denuncia_id` ASC) ,
  INDEX `fk_denuncia_comentario_comentario1_idx` (`comentario_id` ASC) ,
  CONSTRAINT `fk_denuncia_comentario_publicacao_denuncia1`
    FOREIGN KEY (`publicacao_denuncia_id` )
    REFERENCES `teoteca`.`publicacao_denuncia` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_denuncia_comentario_comentario1`
    FOREIGN KEY (`comentario_id` )
    REFERENCES `teoteca`.`comentario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `teoteca` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
