DROP DATABASE IF EXISTS verkkokauppa;

CREATE DATABASE verkkokauppa /*!40100 COLLATE 'utf8_general_ci' */;
USE verkkokauppa;

CREATE TABLE UserDB
(
    UserId INT NOT NULL AUTO_INCREMENT,
    Credits DOUBLE DEFAULT 0,
    FirstName VARCHAR(100),
    LastName VARCHAR(100),
    Email VARCHAR(100),
    TelNum VARCHAR(100),
    StreetAddress VARCHAR(100),
    Zipcode VARCHAR(100),
    City VARCHAR(100),
    Country VARCHAR(100),
    UserRating FLOAT,
    UserName VARCHAR(100) NOT NULL,
    UserPassword VARCHAR(100) NOT NULL,
    PRIMARY KEY (UserId)
);

CREATE TABLE ItemDB
(
    ItemId INT NOT NULL AUTO_INCREMENT,
    ItemName VARCHAR(100),
    ItemCategory VARCHAR(100),
    ItemPrice DOUBLE,
    ItemDescription VARCHAR(100),
    ItemSubCategory VARCHAR(100),
    ImageLink VARCHAR(100) DEFAULT 'default',
    Availability BOOLEAN DEFAULT '1',
    PRIMARY KEY (ItemId)
);

CREATE TABLE OrderDB
(
    OrderId INT NOT NULL AUTO_INCREMENT,
    Quantity INT,
    ItemId INT,
    UserId INT,
    TotalPrice DOUBLE,
    IsBought BOOLEAN DEFAULT '0',
    Timeoforder DATETIME(2) NOT NULL ON UPDATE CURRENT_TIMESTAMP ,
    PRIMARY KEY (OrderId),
    FOREIGN KEY (ItemId) REFERENCES ItemDB(ItemId),
    FOREIGN KEY (UserId) REFERENCES UserDB(UserId)
);

INSERT INTO `verkkokauppa`.`itemdb` (`ItemId`, `ItemName`, `ItemCategory`, `ItemPrice`, `ItemDescription`, `ItemSubCategory`, `ImageLink`, `Availability`) VALUES ('1', 'Testituote', 'Testituottet', '2.00', 'Tämä on testituote', 'Testituotteet alikategoria', default, '1');
INSERT INTO `verkkokauppa`.`itemdb` (`ItemId`, `ItemName`, `ItemCategory`, `ItemPrice`, `ItemDescription`, `ItemSubCategory`, `ImageLink`, `Availability`) VALUES ('2', 'Testituote2', 'Testituottet', '1.50', 'Tämä on toinen testituote', 'Testituotteet alikategoria2', default, '1');
INSERT INTO `verkkokauppa`.`itemdb` (`ItemId`, `ItemName`, `ItemCategory`, `ItemPrice`, `ItemDescription`, `ItemSubCategory`, `ImageLink`, `Availability`) VALUES ('3', 'Testituote3', 'Testituottet2', '1.00', 'Tämä on kolmas testituote', 'Testituotteet2 alikategoria', default, '1');
INSERT INTO `verkkokauppa`.`itemdb` (`ItemId`, `ItemName`, `ItemCategory`, `ItemPrice`, `ItemDescription`, `ItemSubCategory`, `ImageLink`, `Availability`) VALUES ('4', 'Testituote4', 'Testituottet2', '1.25', 'Tämä on neljäs testituote', 'Testituotteet2 alikategoria', default, '1');
INSERT INTO `verkkokauppa`.`itemdb` (`ItemId`, `ItemName`, `ItemCategory`, `ItemPrice`, `ItemDescription`, `ItemSubCategory`, `ImageLink`, `Availability`) VALUES ('5', 'Testituote5', 'Testituottet', '5.45', 'Tämä on viides testituote', 'Testituotteet alikategoria', default, '1');
INSERT INTO `verkkokauppa`.`itemdb` (`ItemId`, `ItemName`, `ItemCategory`, `ItemPrice`, `ItemDescription`, `ItemSubCategory`, `ImageLink`, `Availability`) VALUES ('6', 'Testituote6', 'Testituottet', '3.32', 'Tämä on kuudes testituote', 'Testituotteet alikategoria', default, '1');