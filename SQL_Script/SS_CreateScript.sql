DROP DATABASE IF EXISTS `SGU_SystemSecurity`;
CREATE DATABASE IF NOT EXISTS `SGU_SystemSecurity`;

USE `SGU_SystemSecurity`;

-- Account Table
CREATE TABLE IF NOT EXISTS `Account` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` NVARCHAR(50) NOT NULL UNIQUE,
  `role`	ENUM("Manager", "Admin") NOT NULL,
  `status`	BOOLEAN NOT NULL,
  `password` NVARCHAR(255) NOT NULL
);

-- Profile Table
CREATE TABLE IF NOT EXISTS `Profile` (
  `code` NVARCHAR(255) NOT NULL PRIMARY KEY,
  `birthday` DATE NOT NULL,
  `status` BOOLEAN NOT NULL,
  `createAt` DATETIME NOT NULL,
  `updateAt` DATETIME NOT NULL,
  `gender` ENUM ("Male", "Female", "Other") NOT NULL ,
  `position` ENUM("Employee", "Manager") NOT NULL,
  `fullname` NVARCHAR(255) NOT NULL,
  `phone` NVARCHAR(255) NOT NULL,
  `email` NVARCHAR(255) NOT NULL,
  `accountId` INT UNIQUE,
  FOREIGN KEY (`accountId`) REFERENCES `Account`(`id`)
);

-- FingerPrint Table
CREATE TABLE IF NOT EXISTS `FingerPrint` (
  `profileCode` NVARCHAR(255) ,
  `imageName` VARCHAR(255) NOT NULL,
  `path` VARCHAR(255) NOT NULL,
  `createAt` DATETIME NOT NULL,
  PRIMARY KEY (`ProfileCode`, `imageName`),
  FOREIGN KEY (`profileCode`) REFERENCES `Profile`(`code`)
);

-- Shift Table
CREATE TABLE IF NOT EXISTS `Shift` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `createAt` DATETIME NOT NULL,
  `updateAt` DATETIME NOT NULL,
  `startTime` DATETIME NOT NULL,
  `endTime` DATETIME NOT NULL,
  `breakStartTime` DATETIME,
  `breakEndTime` DATETIME,
  `shiftName` NVARCHAR(255) NOT NULL,
  `isActive` BOOLEAN NOT NULL,
  `isOT` BOOLEAN NOT NULL
);

CREATE TABLE IF NOT EXISTS `ShiftSignUp` (
  `shiftId` INT ,
  `profileCode` NVARCHAR(255) ,
  `signUpTime` DATETIME NOT NULL,
	PRIMARY KEY (`ShiftId`, `ProfileCode`),
	FOREIGN KEY (`shiftId`) 			REFERENCES `Shift`(`id`) ,
	FOREIGN KEY (`profileCode`) 		REFERENCES `Profile`(`code`)
);

-- CheckIn Table
CREATE TABLE IF NOT EXISTS `CheckIn` (
  `shiftId` INT ,
  `profileCode` NVARCHAR(255) ,
  `checkInTime` DATETIME NOT NULL,
  `Status`		ENUM("OnTime", "Late") NOT NULL,
--   `isValid`		BOOLEAN NOT NULL,
  `image` NVARCHAR(255) NOT NULL,
  PRIMARY KEY(`shiftId`, `profileCode`),
  FOREIGN KEY (`shiftId`) 			REFERENCES `Shift`(`id`) ,
  FOREIGN KEY (`profileCode`) 		REFERENCES `Profile`(`code`)
);

-- CheckOut Table
CREATE TABLE IF NOT EXISTS `CheckOut` (
  `shiftId` INT ,
  `profileCode` NVARCHAR(255) ,
  `checkOutTime` DATETIME NOT NULL,
  `Status`	ENUM("OnTime", "LeavingEarly") NOT NULL,
--   `isValid`		BOOLEAN NOT NULL,

  `image` NVARCHAR(255) NOT NULL,
	PRIMARY KEY(`shiftId`, `profileCode`),
  FOREIGN KEY (`shiftId`) REFERENCES `Shift`(`id`) ,
  FOREIGN KEY (`profileCode`) REFERENCES `Profile`(`code`) 
);

