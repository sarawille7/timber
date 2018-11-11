.mode columns
.headers on
.nullvalue NULL
PRAGMA foreign_keys = ON;

CREATE TABLE Users(
    userID INTEGER PRIMARY KEY,
    username TEXT UNIQUE, --TODO include regex check for alphanumeric password
    password TEXT, --FIXME this probably will be changed to an integer representing a hashcode
    privileges TEXT CHECK(privileges IN ("general", "admin")) --all lowercase
);

CREATE TABLE Trees(
    treeID INTEGER PRIMARY KEY,
    userID INTEGER CHECK(userID IN SELECT userID FROM Users.userID), -- probably don't need this check
    name TEXT, --TODO restricted to alphabet
    photoID INTEGER, --TODO HOPEFULLY THIS IS STRAIGHTFORWARD??
    rings INTEGER CHECK(rings > 0),
    descript TEXT CHECK(VARCHAR(descript) <= 280), --i think VARCHAR works for this?
    species TEXT, --potentially just restrict this on website, not within database
    height REAL, CHECK(height > 0) CHECK(height < 500), --TODO regex to restrict to hundredths place
);

CREATE TABLE Matches(
    userID INTEGER,
    treeID INTEGER,
    matchDate TEXT, --TODO: regex to match time format
    FOREIGN KEY (userID) REFERENCES Users(userID),
        ON UPDATE CASCADE
        ON DELETE CASCADE
    FOREIGN KEY (treeID) REFERENCES Trees(treeID),
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE Banned(
    userID INTEGER UNIQUE,
    banDate TEXT, --TODO: regex to match time format
    FOREIGN KEY (userID) REFERENCES Users(userID),
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
