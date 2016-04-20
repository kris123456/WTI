-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema testcs
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema testcs
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `testcs` DEFAULT CHARACTER SET latin1 ;
USE `testcs` ;

-- -----------------------------------------------------
-- Table `testcs`.`addresses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`addresses` (
  `id_adress` INT(11) NOT NULL AUTO_INCREMENT,
  `city` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `province` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `country` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `postal_code` VARCHAR(10) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `street` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `number_house` VARCHAR(20) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `number_local` VARCHAR(20) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`id_adress`))
ENGINE = InnoDB
AUTO_INCREMENT = 41
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `testcs`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`category` (
  `id_category` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `description2` TEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`id_category`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `testcs`.`contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`contact` (
  `id_contact` INT(11) NOT NULL AUTO_INCREMENT,
  `number_telephone` VARCHAR(30) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `fax` VARCHAR(30) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `email` VARCHAR(30) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `site` VARCHAR(30) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`id_contact`))
ENGINE = InnoDB
AUTO_INCREMENT = 38
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `testcs`.`client`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`client` (
  `id_client` INT(11) NOT NULL AUTO_INCREMENT,
  `id_adress` INT(11) NULL DEFAULT NULL,
  `id_contact` INT(11) NULL DEFAULT NULL,
  `user_login` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `md5_pass` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `name` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `nip` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `client_type` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `data_rejestracji` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `surname` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `privileges` INT(11) NULL DEFAULT NULL,
  `date_last_logged` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id_client`),
  INDEX `id_adress` (`id_adress` ASC),
  INDEX `id_contact` (`id_contact` ASC),
  CONSTRAINT `Client_ibfk_1`
    FOREIGN KEY (`id_adress`)
    REFERENCES `testcs`.`addresses` (`id_adress`),
  CONSTRAINT `Client_ibfk_2`
    FOREIGN KEY (`id_contact`)
    REFERENCES `testcs`.`contact` (`id_contact`))
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `testcs`.`employee`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`employee` (
  `id_employee` INT(11) NOT NULL AUTO_INCREMENT,
  `id_adress` INT(11) NULL DEFAULT NULL,
  `id_contact` INT(11) NULL DEFAULT NULL,
  `user_login` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `md5_pass` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `name` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `privileges` VARCHAR(10) CHARACTER SET 'utf8' NOT NULL,
  `start_of_work` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id_employee`),
  INDEX `id_adress` (`id_adress` ASC),
  INDEX `id_contact` (`id_contact` ASC),
  CONSTRAINT `Employee_ibfk_1`
    FOREIGN KEY (`id_adress`)
    REFERENCES `testcs`.`addresses` (`id_adress`),
  CONSTRAINT `Employee_ibfk_2`
    FOREIGN KEY (`id_contact`)
    REFERENCES `testcs`.`contact` (`id_contact`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `testcs`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`orders` (
  `id_order` INT(11) NOT NULL AUTO_INCREMENT,
  `id_client` INT(11) NULL DEFAULT NULL,
  `is_accepted` INT(11) NULL DEFAULT NULL,
  `is_paid` INT(11) NULL DEFAULT NULL,
  `date_order` DATE NULL DEFAULT NULL,
  `date_shipment` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `is_realized` INT(11) NULL DEFAULT NULL,
  `date_realized_order` DATE NULL DEFAULT NULL,
  `time_order` VARCHAR(45) NULL,
  PRIMARY KEY (`id_order`),
  INDEX `id_client` (`id_client` ASC),
  CONSTRAINT `Orders_ibfk_1`
    FOREIGN KEY (`id_client`)
    REFERENCES `testcs`.`client` (`id_client`))
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `testcs`.`producer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`producer` (
  `id_producer` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `regon` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `nip` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `telephone` VARCHAR(20) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`id_producer`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `testcs`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`products` (
  `id_product` INT(11) NOT NULL AUTO_INCREMENT,
  `id_category` INT(11) NULL DEFAULT NULL,
  `id_producer` INT(11) NULL DEFAULT NULL,
  `name_product` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL,
  `descriptions` TEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `photography` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `price_netto` DECIMAL(10,2) NULL DEFAULT NULL,
  `price_brutto` DECIMAL(10,2) NULL DEFAULT NULL,
  `percent_vat` DECIMAL(5,2) NULL DEFAULT NULL,
  `discount` DECIMAL(10,2) NULL DEFAULT NULL,
  `amount` INT(11) NULL DEFAULT NULL,
  `date_add_products` DATE NULL,
  PRIMARY KEY (`id_product`),
  INDEX `id_category` (`id_category` ASC),
  INDEX `id_producer` (`id_producer` ASC),
  CONSTRAINT `Products_ibfk_1`
    FOREIGN KEY (`id_category`)
    REFERENCES `testcs`.`category` (`id_category`),
  CONSTRAINT `Products_ibfk_2`
    FOREIGN KEY (`id_producer`)
    REFERENCES `testcs`.`producer` (`id_producer`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `testcs`.`photogallery`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`photogallery` (
  `id_photo` INT(11) NOT NULL AUTO_INCREMENT,
  `id_product` INT(11) NULL DEFAULT NULL,
  `name` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `date_add` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id_photo`),
  INDEX `id_product` (`id_product` ASC),
  CONSTRAINT `Photogallery_ibfk_1`
    FOREIGN KEY (`id_product`)
    REFERENCES `testcs`.`products` (`id_product`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `testcs`.`tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`tag` (
  `id_tag` INT(11) NOT NULL AUTO_INCREMENT,
  `name_tag` VARCHAR(45) NULL,
  PRIMARY KEY (`id_tag`),
  UNIQUE INDEX `id_tag_UNIQUE` (`id_tag` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name_tag` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `testcs`.`products_has_tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`products_has_tag` (
  `id_product` INT(11) NOT NULL,
  `id_tag` INT(11) NOT NULL,
  PRIMARY KEY (`id_product`, `id_tag`),
  INDEX `fk_products_has_tag_tag1_idx` (`id_tag` ASC),
  INDEX `fk_products_has_tag_products1_idx` (`id_product` ASC),
  CONSTRAINT `fk_products_has_tag_products1`
    FOREIGN KEY (`id_product`)
    REFERENCES `testcs`.`products` (`id_product`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_products_has_tag_tag1`
    FOREIGN KEY (`id_tag`)
    REFERENCES `testcs`.`tag` (`id_tag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `testcs`.`ordersproducts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `testcs`.`ordersproducts` (
  `id_order` INT(11) NOT NULL,
  `id_product` INT(11) NOT NULL,
  `amount_products` INT(11) NOT NULL,
  PRIMARY KEY (`id_order`, `id_product`),
  INDEX `fk_orders_has_products_products1_idx` (`id_product` ASC),
  INDEX `fk_orders_has_products_orders1_idx` (`id_order` ASC),
  CONSTRAINT `fk_orders_has_products_orders1`
    FOREIGN KEY (`id_order`)
    REFERENCES `testcs`.`orders` (`id_order`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_has_products_products1`
    FOREIGN KEY (`id_product`)
    REFERENCES `testcs`.`products` (`id_product`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;