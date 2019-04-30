DROP DATABASE IF EXISTS verkkokauppa;

CREATE DATABASE verkkokauppa /*!40100 COLLATE 'utf8_general_ci' */;
USE verkkokauppa;

CREATE TABLE UserDB
(
  UserId INT NOT NULL,
  Credits INT NOT NULL,
  FirstName VARCHAR(100) NOT NULL,
  LastName VARCHAR(100) NOT NULL,
  Email VARCHAR(100) NOT NULL,
  TelNum VARCHAR(100) NOT NULL,
  StreetAddress VARCHAR(100) NOT NULL,
  Zipcode VARCHAR(100) NOT NULL,
  City VARCHAR(100) NOT NULL,
  Country VARCHAR(100) NOT NULL,
  UserRating FLOAT NOT NULL,
  UserName VARCHAR(100) NOT NULL,
  UserPassword VARCHAR(100) NOT NULL,
  PRIMARY KEY (UserId)
);

CREATE TABLE ItemDB
(
  ItemId INT NOT NULL,
  ItemName VARCHAR(100) NOT NULL,
  ItemCategory VARCHAR(100) NOT NULL,
  ItemPrice FLOAT NOT NULL,
  ItemDescription VARCHAR(100) NOT NULL,
  ItemSubCategory VARCHAR(100) NOT NULL,
  ImageLink VARCHAR(100) NOT NULL,
  IsSold BOOLEAN NOT NULL,
  BuyerId INT NOT NULL,
  UserId INT,
  PRIMARY KEY (ItemId),
  FOREIGN KEY (UserId) REFERENCES UserDB(UserId)
);