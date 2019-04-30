DROP DATABASE IF EXISTS verkkokauppa;

CREATE DATABASE verkkokauppa /*!40100 COLLATE 'utf8_general_ci' */;
USE verkkokauppa;

CREATE TABLE UserDB
(
  UserId INT NOT NULL,
  Credits INT NOT NULL,
  FirstName INT NOT NULL,
  LastName INT NOT NULL,
  Email INT NOT NULL,
  TelNum INT NOT NULL,
  StreetAddress INT NOT NULL,
  Zipcode INT NOT NULL,
  City INT NOT NULL,
  Country INT NOT NULL,
  UserRating INT NOT NULL,
  PRIMARY KEY (UserId)
);

CREATE TABLE ItemDB
(
  ItemId INT NOT NULL,
  ItemName INT NOT NULL,
  ItemCategory INT NOT NULL,
  ItemPrice INT NOT NULL,
  ItemDescription INT NOT NULL,
  ItemSubCategory INT NOT NULL,
  ImageLink INT NOT NULL,
  IsSold INT NOT NULL,
  BuyerId INT NOT NULL,
  UserId INT,
  PRIMARY KEY (ItemId),
  FOREIGN KEY (UserId) REFERENCES UserDB(UserId)
);