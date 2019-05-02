DROP DATABASE IF EXISTS verkkokauppa;

CREATE DATABASE verkkokauppa /*!40100 COLLATE 'utf8_general_ci' */;
USE verkkokauppa;

CREATE TABLE UserDB
(
    UserId INT NOT NULL AUTO_INCREMENT,
    Credits INT,
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
    ItemPrice FLOAT,
    ItemDescription VARCHAR(100),
    ItemSubCategory VARCHAR(100),
    ImageLink VARCHAR(100),
    IsSold BOOLEAN,
    BuyerId INT,
    UserId INT,
    PRIMARY KEY (ItemId),
    FOREIGN KEY (UserId) REFERENCES UserDB(UserId)
);