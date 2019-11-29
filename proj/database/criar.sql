PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS User;
CREATE TABLE User(


  Id INTEGER NOT NULL ON CONFLICT ABORT,
  Name TEXT NOT NULL ON CONFLICT ABORT,
  DateOfBirth DATE NOT NULL ON CONFLICT ABORT,
  Email TEXT NOT NULL ON CONFLICT ABORT,
  Username TEXT NOT NULL ON CONFLICT ABORT,
  Password TEXT NOT NULL ON CONFLICT ABORT,
  CHECK (date('now')-DateOfBirth > 18),
  UNIQUE(Email),
  UNIQUE(Username),
  PRIMARY KEY(Id)
);


DROP TABLE IF EXISTS Available;
CREATE TABLE Available(
  Id INTEGER NOT NULL ON CONFLICT ABORT,
  StartDate DATE NOT NULL ON CONFLICT ABORT,
  EndDate DATE NOT NULL ON CONFLICT ABORT,
  Discount INTEGER NOT NULL ON CONFLICT ABORT,
  HouseId INTEGER NOT NULL ON CONFLICT ABORT,
  FOREIGN KEY(HouseId) REFERENCES House(Id) ON DELETE SET NULL	ON UPDATE CASCADE,
  PRIMARY KEY(Id),
  
  CHECK(EndDate > StartDate)
);

DROP TABLE IF EXISTS House;
CREATE TABLE House(
  
  Id INTEGER NOT NULL ON CONFLICT ABORT,
  Name TEXT NOT NULL ON CONFLICT ABORT,
  Rating REAL DEFAULT(NULL),
  PricePerDay INTEGER,  
  Description TEXT DEFAULT(NULL),
  Address TEXT NOT NULL ON CONFLICT ABORT,
  PostalCode TEXT NOT NULL ON CONFLICT ABORT,
  OwnerId INTEGER NOT NULL ON CONFLICT ABORT,
  CityId INTEGER NOT NULL ON CONFLICT ABORT,
  FOREIGN KEY(CityId) REFERENCES City(Id) ON DELETE SET NULL	ON UPDATE CASCADE,
  FOREIGN KEY(OwnerId) REFERENCES User(Id) ON DELETE SET NULL	ON UPDATE CASCADE,
  PRIMARY KEY(Id)
  
);

DROP TABLE IF EXISTS Country;
CREATE TABLE Country(
  Id INTEGER NOT NULL ON CONFLICT ABORT,
  Name TEXT NOT NULL ON CONFLICT ABORT,
  ISO TEXT NOT NULL ON CONFLICT ABORT,
  UNIQUE(Name),

  PRIMARY KEY (Id)
);

DROP TABLE IF EXISTS City;
CREATE TABLE City(
  Id INTEGER NOT NULL ON CONFLICT ABORT,
  Name TEXT NOT NULL ON CONFLICT ABORT,
  CountryId INTEGER,
  
  FOREIGN KEY(CountryId) REFERENCES Country(Id) ON DELETE SET NULL ON UPDATE CASCADE,
  PRIMARY KEY(Id)
);



DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment(
  Id INTEGER NOT NULL ON CONFLICT ABORT,
  Text TEXT NOT NULL ON CONFLICT ABORT,
  Date DATE NOT NULL ON CONFLICT ABORT,

  ReviewId Integer NOT NULL ON CONFLICT ABORT,
  FOREIGN KEY(ReviewId) REFERENCES Review(Id) ON DELETE SET NULL ON UPDATE CASCADE,

  PRIMARY KEY(Id)
);

DROP TABLE IF EXISTS Commodity;
CREATE TABLE Commodity(
  Id INTEGER NOT NULL ON CONFLICT ABORT,
  Description TEXT NOT NULL ON CONFLICT ABORT,
  Type TEXT NOY NULL ON CONFLICT ABORT,
  HouseId INTEGER,
  
  FOREIGN KEY(HouseId) REFERENCES House(Id) ON DELETE SET NULL ON UPDATE CASCADE,
  PRIMARY KEY(Id)
);

DROP TABLE IF EXISTS Photo;
CREATE TABLE Photo(
  Id INTEGER NOT NULL ON CONFLICT ABORT,
  Description TEXT NOT NULL ON CONFLICT ABORT,
  HouseId INTEGER,
  
  FOREIGN KEY(HouseId) REFERENCES House(Id) ON DELETE SET NULL ON UPDATE CASCADE,
  PRIMARY KEY(Id)
);

DROP TABLE IF EXISTS Rent;
CREATE TABLE Rent(
  Id INTEGER NOT NULL ON CONFLICT ABORT, 
  StartDate DATE NOT NULL ON CONFLICT ABORT,
  EndDate DATE NOT NULL ON CONFLICT ABORT,
  NumberOfDays INTEGER DEFAULT(NULL),
  Price INTEGER DEFAULT(NULL),
  HouseId INTEGER NOT NULL ON CONFLICT ABORT,
  TouristId INTEGER NOT NULL ON CONFLICT ABORT,
  FOREIGN KEY(HouseId) REFERENCES House(Id) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY(TouristId) REFERENCES User(Id) ON DELETE SET NULL ON UPDATE CASCADE,
  PRIMARY KEY(Id)
);

DROP TABLE IF EXISTS Review;
CREATE TABLE Review(
  Id INTEGER NOT NULL ON CONFLICT ABORT,
  Rating INTEGER DEFAULT(NULL),
  RentId INTEGER,
  FOREIGN KEY(RentId) REFERENCES Rent(Id) ON DELETE SET NULL ON UPDATE CASCADE,
  PRIMARY KEY(Id),

  CHECK(rating >= 1 AND rating <= 5)
);


DROP TABLE IF EXISTS Photo;
CREATE TABLE Photo(
  Id INTEGER NOT NULL ON CONFLICT ABORT,
  HouseId INTEGER,
  Description TEXT,
  Path TEXT NOT NULL ON CONFLICT ABORT,
  FOREIGN KEY(HouseId) REFERENCES House(Id) ON DELETE SET NULL ON UPDATE CASCADE,
  PRIMARY KEY(Id)
);
