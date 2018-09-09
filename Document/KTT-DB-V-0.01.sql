-- MySQL Script generated by MySQL Workbench
-- Sun Sep  9 17:16:26 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema ktt
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `ktt` ;

-- -----------------------------------------------------
-- Schema ktt
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ktt` DEFAULT CHARACTER SET utf8 ;
USE `ktt` ;

-- -----------------------------------------------------
-- Table `ktt`.`account`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`account` ;

CREATE TABLE IF NOT EXISTS `ktt`.`account` (
  `accId` INT NOT NULL AUTO_INCREMENT,
  `accFirstname` VARCHAR(45) NULL,
  `accLastname` VARCHAR(45) NULL,
  `accUsername` VARCHAR(45) NULL,
  `accPassword` LONGTEXT NULL,
  `accCreatedate` TIMESTAMP(6) NULL,
  `accUpdatedate` TIMESTAMP(6) NULL,
  `accDeletedate` TIMESTAMP(6) NULL,
  `accCreateBy` INT NULL,
  `accUpdateBy` INT NULL,
  `accDeleteBy` INT NULL,
  PRIMARY KEY (`accId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`address` ;

CREATE TABLE IF NOT EXISTS `ktt`.`address` (
  `addId` INT NOT NULL AUTO_INCREMENT,
  `addDetail` VARCHAR(45) NULL,
  `addProvince` VARCHAR(45) NULL,
  `addDistrict` VARCHAR(45) NULL,
  `addPostcode` VARCHAR(45) NULL,
  `addType` VARCHAR(45) NULL,
  `addCusId` INT NOT NULL,
  `addCtrId` INT NOT NULL,
  PRIMARY KEY (`addId`, `addCusId`, `addCtrId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`bank`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`bank` ;

CREATE TABLE IF NOT EXISTS `ktt`.`bank` (
  `banId` INT NOT NULL AUTO_INCREMENT,
  `banName` VARCHAR(45) NULL,
  PRIMARY KEY (`banId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`bankAccount`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`bankAccount` ;

CREATE TABLE IF NOT EXISTS `ktt`.`bankAccount` (
  `bacId` INT NOT NULL AUTO_INCREMENT,
  `bacNumber` VARCHAR(45) NULL,
  `bacBranch` VARCHAR(45) NULL,
  `bacName` VARCHAR(45) NULL,
  `bacCusId` INT NOT NULL,
  `bacBanId` INT NOT NULL,
  PRIMARY KEY (`bacId`, `bacCusId`, `bacBanId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`commission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`commission` ;

CREATE TABLE IF NOT EXISTS `ktt`.`commission` (
  `cmsId` INT NOT NULL AUTO_INCREMENT,
  `cmsTotalPrivatePoint` DOUBLE NULL,
  `cmsTotalPublicPoint` DOUBLE NULL,
  `cmsTotalPoint` DOUBLE NULL,
  `cmsTotalCommission` DOUBLE NULL,
  `cmsCycleDateStart` DATE NULL,
  `cmsCycleDateEnd` DATE NULL,
  `cmsCusId` INT NOT NULL,
  `cmsCmrId` INT NOT NULL,
  PRIMARY KEY (`cmsId`, `cmsCusId`, `cmsCmrId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`commissionReport`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`commissionReport` ;

CREATE TABLE IF NOT EXISTS `ktt`.`commissionReport` (
  `cmrId` INT NOT NULL AUTO_INCREMENT,
  `cmrDate` VARCHAR(45) NULL,
  PRIMARY KEY (`cmrId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`contact`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`contact` ;

CREATE TABLE IF NOT EXISTS `ktt`.`contact` (
  `conId` INT NOT NULL AUTO_INCREMENT,
  `conName` VARCHAR(45) NULL,
  `conValue` VARCHAR(45) NULL,
  `conCusId` INT NOT NULL,
  PRIMARY KEY (`conId`, `conCusId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`country`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`country` ;

CREATE TABLE IF NOT EXISTS `ktt`.`country` (
  `ctrId` INT NOT NULL,
  `ctrName` VARCHAR(45) NULL,
  PRIMARY KEY (`ctrId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`country`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`country` ;

CREATE TABLE IF NOT EXISTS `ktt`.`country` (
  `ctrId` INT NOT NULL,
  `ctrName` VARCHAR(45) NULL,
  PRIMARY KEY (`ctrId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`customer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`customer` ;

CREATE TABLE IF NOT EXISTS `ktt`.`customer` (
  `cusId` INT NOT NULL AUTO_INCREMENT,
  `cusFanshineName` VARCHAR(45) NULL,
  `cusFullName` VARCHAR(45) NULL,
  `cusDateOfBirth` DATE NULL,
  `cusPassportId` VARCHAR(45) NULL,
  `cusPersonalId` VARCHAR(45) NULL,
  `cusMarital` VARCHAR(10) NULL,
  `cusChild` INT NULL,
  `cusDescedant` VARCHAR(45) NULL,
  `cusLevel` VARCHAR(45) NULL,
  `cusCreatedate` TIMESTAMP(6) NULL,
  `cusDeletedate` TIMESTAMP(6) NULL,
  `cusUpdatedate` TIMESTAMP(6) NULL,
  `cusCreateBy` INT NULL,
  `cusDeleteBy` INT NULL,
  `cusUpdateBy` INT NULL,
  `cusReferId` INT NULL,
  `cusCouId` INT NOT NULL,
  PRIMARY KEY (`cusId`, `cusCouId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`district`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`district` ;

CREATE TABLE IF NOT EXISTS `ktt`.`district` (
  `disId` INT NOT NULL,
  `disName` VARCHAR(45) NULL,
  `disPrvId` INT NOT NULL,
  PRIMARY KEY (`disId`, `disPrvId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`expense`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`expense` ;

CREATE TABLE IF NOT EXISTS `ktt`.`expense` (
  `epnId` INT NOT NULL AUTO_INCREMENT,
  `epnType` VARCHAR(45) NULL,
  `epnTitle` VARCHAR(45) NULL,
  `epnDetail` TEXT NULL,
  `epnAmount` DOUBLE NULL,
  `epnSection` VARCHAR(45) NULL,
  `epnCusId` INT NOT NULL,
  PRIMARY KEY (`epnId`, `epnCusId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`levelUp`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`levelUp` ;

CREATE TABLE IF NOT EXISTS `ktt`.`levelUp` (
  `lvuId` INT NOT NULL,
  `lvuFrom` VARCHAR(5) NULL,
  `lvuTo` VARCHAR(5) NULL,
  `lvuDate` TIMESTAMP(6) NULL,
  `levelPay` DOUBLE NULL,
  `lvuCusId` INT NOT NULL,
  PRIMARY KEY (`lvuId`, `lvuCusId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`location`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`location` ;

CREATE TABLE IF NOT EXISTS `ktt`.`location` (
  `locId` INT NOT NULL AUTO_INCREMENT,
  `locName` VARCHAR(45) NULL,
  `locDetail` TEXT NULL,
  `locCreatedate` TIMESTAMP(6) NULL,
  `locUpdatedate` TIMESTAMP(6) NULL,
  `locDeletedate` TIMESTAMP(6) NULL,
  `locCreateBy` INT NULL,
  `locUpdateBy` INT NULL,
  `locDeleteBy` INT NULL,
  PRIMARY KEY (`locId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`lot`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`lot` ;

CREATE TABLE IF NOT EXISTS `ktt`.`lot` (
  `lotId` INT NOT NULL AUTO_INCREMENT,
  `lotStockInDate` TIMESTAMP(6) NULL,
  `lotExpireDate` DATE NULL,
  `lotFreeQty` DOUBLE NULL,
  `lotUseQty` TINYINT NULL,
  `lotCost` DOUBLE NULL,
  `lotMatId` INT NOT NULL,
  `lotLocId` INT NOT NULL,
  PRIMARY KEY (`lotId`, `lotMatId`, `lotLocId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`material`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`material` ;

CREATE TABLE IF NOT EXISTS `ktt`.`material` (
  `matId` INT NOT NULL AUTO_INCREMENT,
  `matName` VARCHAR(45) NULL,
  `matCode` VARCHAR(45) NULL,
  `matMin` VARCHAR(45) NULL,
  `matMax` VARCHAR(45) NULL,
  `marCreatedate` TIMESTAMP(6) NULL,
  `matUpdatedate` TIMESTAMP(6) NULL,
  `matDeletedate` TIMESTAMP(6) NULL,
  `matCreateBy` INT NULL,
  `matUpdateBy` INT NULL,
  `matDeleteBy` INT NULL,
  `matLocId` INT NOT NULL,
  `matUntId` INT NOT NULL,
  `matType` VARCHAR(45) NULL,
  PRIMARY KEY (`matId`, `matLocId`, `matUntId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`module` ;

CREATE TABLE IF NOT EXISTS `ktt`.`module` (
  `modId` INT NOT NULL AUTO_INCREMENT,
  `modName` VARCHAR(45) NULL,
  `modSection` VARCHAR(45) NULL,
  PRIMARY KEY (`modId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`order` ;

CREATE TABLE IF NOT EXISTS `ktt`.`order` (
  `ordId` INT NOT NULL AUTO_INCREMENT,
  `ordCode` VARCHAR(45) NULL,
  `ordStatus` VARCHAR(45) NULL,
  `ordSubTotal` VARCHAR(45) NULL,
  `ordShipping` VARCHAR(45) NULL,
  `ordTax` VARCHAR(45) NULL,
  `ordTotal` VARCHAR(45) NULL,
  `ordCusId` INT NOT NULL,
  PRIMARY KEY (`ordId`, `ordCusId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`permission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`permission` ;

CREATE TABLE IF NOT EXISTS `ktt`.`permission` (
  `perId` INT NOT NULL AUTO_INCREMENT,
  `perAccId` INT NOT NULL,
  `perModId` INT NOT NULL,
  PRIMARY KEY (`perId`, `perAccId`, `perModId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`point`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`point` ;

CREATE TABLE IF NOT EXISTS `ktt`.`point` (
  `pntId` INT NOT NULL AUTO_INCREMENT,
  `pntTitle` VARCHAR(45) NULL,
  `pntValue` DOUBLE NULL,
  `pntType` VARCHAR(45) NULL,
  `pntCurrency` VARCHAR(45) NULL,
  `pntRefId` INT NULL,
  `pntCreatedate` TIMESTAMP(6) NULL,
  `pntCusId` INT NOT NULL,
  `pntCmsId` INT NOT NULL,
  PRIMARY KEY (`pntId`, `pntCusId`, `pntCmsId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`product` ;

CREATE TABLE IF NOT EXISTS `ktt`.`product` (
  `prdId` INT NOT NULL AUTO_INCREMENT,
  `prdCost` DOUBLE NULL,
  `prdDiscount` DOUBLE NULL,
  `prdPoint` DOUBLE NULL,
  `prdCreatedate` TIMESTAMP(6) NULL,
  `prdUpdatedate` TIMESTAMP(6) NULL,
  `prdDeletedate` TIMESTAMP(6) NULL,
  `prdCreateBy` INT NULL,
  `prdUpdateBy` INT NULL,
  `prdDeleteBy` INT NULL,
  `prdMatId` INT NOT NULL,
  `prdFullPrice` DOUBLE NULL,
  PRIMARY KEY (`prdId`, `prdMatId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`productPrice`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`productPrice` ;

CREATE TABLE IF NOT EXISTS `ktt`.`productPrice` (
  `pdpId` INT NOT NULL,
  `pdpCost` DOUBLE NULL,
  `pdpDiscount` DOUBLE NULL,
  `pdpPoint` DOUBLE NULL,
  `pdpPrdId` INT NOT NULL,
  PRIMARY KEY (`pdpId`, `pdpPrdId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`province`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`province` ;

CREATE TABLE IF NOT EXISTS `ktt`.`province` (
  `prvId` INT NOT NULL,
  `prdName` VARCHAR(45) NULL,
  `prvDtrId` INT NOT NULL,
  PRIMARY KEY (`prvId`, `prvDtrId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`settingDefault`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`settingDefault` ;

CREATE TABLE IF NOT EXISTS `ktt`.`settingDefault` (
  `sedId` INT NOT NULL AUTO_INCREMENT,
  `sedName` VARCHAR(45) NULL,
  `sedValue` DOUBLE NULL,
  PRIMARY KEY (`sedId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`settingSchedule`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`settingSchedule` ;

CREATE TABLE IF NOT EXISTS `ktt`.`settingSchedule` (
  `sscId` INT NOT NULL AUTO_INCREMENT,
  `sscValue` DOUBLE NULL,
  `sscName` VARCHAR(45) NULL,
  PRIMARY KEY (`sscId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`settingScheduleGroup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`settingScheduleGroup` ;

CREATE TABLE IF NOT EXISTS `ktt`.`settingScheduleGroup` (
  `ssgId` INT NOT NULL,
  `ssgDateStart` TIMESTAMP(6) NULL,
  `ssgDateEnd` TIMESTAMP(6) NULL,
  `ssgCreatedate` TIMESTAMP(6) NULL,
  `ssgUpdatedate` TIMESTAMP(6) NULL,
  `ssgDeletedate` TIMESTAMP(6) NULL,
  `ssgCreateBy` INT NULL,
  `ssgUpdateBy` INT NULL,
  `ssgDeleteBy` INT NULL,
  `ssgSscId` INT NOT NULL,
  PRIMARY KEY (`ssgId`, `ssgSscId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`stock`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`stock` ;

CREATE TABLE IF NOT EXISTS `ktt`.`stock` (
  `stoId` INT NOT NULL AUTO_INCREMENT,
  `stoActualStock` DOUBLE NULL,
  `stoVirtualStock` DOUBLE NULL,
  `stoAction` VARCHAR(10) NULL,
  `stoLast` TINYINT NULL,
  `stoCreatedate` TIMESTAMP(6) NULL,
  `stoCreateBy` INT NOT NULL,
  `stoMatId` INT NOT NULL,
  `stoLocId` INT NOT NULL,
  `stoAmount` DOUBLE NULL,
  `stoCost` VARCHAR(45) NULL,
  PRIMARY KEY (`stoId`, `stoMatId`, `stoLocId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`subOrder`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`subOrder` ;

CREATE TABLE IF NOT EXISTS `ktt`.`subOrder` (
  `sodId` INT NOT NULL AUTO_INCREMENT,
  `sodQty` DOUBLE NULL,
  `sodOrdId` INT NOT NULL,
  `sodPrdId` INT NOT NULL,
  PRIMARY KEY (`sodId`, `sodOrdId`, `sodPrdId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ktt`.`unit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ktt`.`unit` ;

CREATE TABLE IF NOT EXISTS `ktt`.`unit` (
  `untId` INT NOT NULL AUTO_INCREMENT,
  `untName` VARCHAR(45) NULL,
  PRIMARY KEY (`untId`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;