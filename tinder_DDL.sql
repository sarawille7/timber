.mode columns
.headers on
.nullvalue NULL
PRAGMA foreign_keys = ON;

CREATE TABLE Users(
    userID INTEGER PRIMARY KEY,
    username TEXT UNIQUE, --TODO include regex check for alphanumeric password
    password TEXT NOT NULL,
    privileges TEXT NOT NULL CHECK(privileges IN ("general", "admin")) --all lowercase
);

--Used for containing possible tree species a user can input
CREATE TABLE PossibleSpecies(
    species TEXT UNIQUE
);

CREATE TABLE Trees(
    treeID INTEGER PRIMARY KEY,
    userID INTEGER NOT NULL,
    name TEXT NOT NULL, --TODO restricted to alphabet
    photoID INTEGER NOT NULL,
    rings INTEGER NOT NULL CHECK(rings > 0),
    descript TEXT NOT NULL CHECK(LENGTH(descript) < 280),
    species TEXT NOT NULL,
    height REAL NOT NULL CHECK(height > 0 AND height < 500), --TODO regex to restrict to hundredths place
    FOREIGN KEY (userID)
        REFERENCES Users (userID)
          ON UPDATE CASCADE
          ON DELETE CASCADE
    FOREIGN KEY (species)
        REFERENCES PossibleSpecies(species)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

CREATE TABLE Matches(
    userID INTEGER NOT NULL,
    treeID INTEGER NOT NULL,
    matchDate TEXT NOT NULL, --TODO: regex to match time format
    PRIMARY KEY (userID, treeID)
    FOREIGN KEY (userID)
        REFERENCES Users (userID)
          ON UPDATE CASCADE
          ON DELETE CASCADE
    FOREIGN KEY (treeID)
        REFERENCES Trees (treeID)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

CREATE TABLE Banned(
    userID INTEGER UNIQUE,
    banDate TEXT NOT NULL, --TODO: regex to match time format
    FOREIGN KEY (userID)
        REFERENCES Users (userID)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

CREATE TABLE UserActivity(
    event TEXT CHECK(event IN ("Deletion", "Insertion", "Update")),
    eventTIme TEXT,
    userID INTEGER,
    oldPassword TEXT,
    oldPrivileges TEXT,
    newPassword TEXT,
    newPrivileges TEXT,
    PRIMARY KEY (userID, eventTime)
    FOREIGN KEY (userID)
        REFERENCES Users (userID)
            ON UPDATE CASCADE
            ON UPDATE CASCADE
);

CREATE TABLE TreeActivity(
    event TEXT CHECK(event IN ("Deletion", "Insertion", "Update")),
    eventTime TEXT,
    treeID INTEGER,
    oldName TEXT NOT NULL,
    oldPhotoID INTEGER NOT NULL,
    oldRings INTEGER NOT NULL,
    oldDescript TEXT NOT NULL,
    oldSpecies TEXT NOT NULL,
    oldHeight REAL NOT NULL,
    newName TEXT NOT NULL,
    newPhotoID INTEGER NOT NULL,
    newRings INTEGER NOT NULL,
    newDescript TEXT NOT NULL,
    newSpecies TEXT NOT NULL, --
    newHeight REAL NOT NULL,
    PRIMARY KEY (treeID, eventTime)
    FOREIGN KEY (treeID)
        REFERENCES Trees (treeID)
            ON UPDATE CASCADE
            ON UPDATE CASCADE
);

CREATE TABLE SpeciesActivity(
    event TEXT CHECK(event IN ("Deletion", "Insertion", "Update")),
    eventTime TEXT,
    oldSpecies TEXT,
    newSpecies TEXT,
    PRIMARY KEY (event, eventTime)
);

CREATE TRIGGER SpeciesEvent_delete
    AFTER DELETE ON PossibleSpecies
        BEGIN
            INSERT INTO SpeciesActivity
            VALUES ('Deletion', datetime('now'), OLD.species, null);
        END;

CREATE TRIGGER SpeciesEvent_insert
    AFTER DELETE ON PossibleSpecies
        BEGIN
            INSERT INTO SpeciesActivity
            VALUES ('Insertion', datetime('now'), null, NEW.species);
        END;

CREATE TRIGGER SpeciesEvent_update
    AFTER DELETE ON PossibleSpecies
        BEGIN
            INSERT INTO SpeciesActivity
            VALUES ('Insertion', datetime('now'), OLD.species, NEW.species);
        END;

CREATE TRIGGER UserEvent_delete
    AFTER DELETE ON Users
        BEGIN
            INSERT INTO UserActivity
            VALUES ('Deletion', datetime('now'), OLD.userID, OLD.password, OLD.privileges, null, null, null);
        END;

CREATE TRIGGER UserEvent_insert
    AFTER DELETE ON Users
        BEGIN
            INSERT INTO UserActivity
            VALUES ('Insertion', datetime('now'), NEW.userID, null, null, null, NEW.password, NEW.privileges);
        END;

CREATE TRIGGER UserEvent_update
    AFTER DELETE ON Users
        BEGIN
            INSERT INTO UserActivity
            VALUES ('Insertion', datetime('now'), OLD.userID, OLD.userID, OLD.password, OLD.privileges, NEW.password, NEW.privileges);
        END;

CREATE TRIGGER TreeEvent_delete
    AFTER DELETE ON Trees
        BEGIN
            INSERT INTO TreeActivity
            VALUES ('Deletion', datetime('now'), OLD.TreeID, OLD.name, OLD.photoID, OLD.rings, OLD.descript, OLD.species, OLD.height, null, null, null, null, null, null);
        END;

CREATE TRIGGER TreeEvent_insert
    AFTER INSERT ON Trees
        BEGIN
            INSERT INTO TreeActivity
            VALUES ('Insertion', datetime('now'), NEW.TreeID, null, null, null, null, null, null, NEW.name, NEW.photoID, NEW.rings, NEW.descript, NEW.species, NEW.height);
                END;

CREATE TRIGGER TreeEvent_update
    AFTER DELETE ON Trees
        BEGIN
            INSERT INTO TreeActivity
            VALUES ('Update', datetime('now'), OLD.TreeID, OLD.name, OLD.photoID, OLD.rings, OLD.descript, OLD.species, OLD.height, NEW.name, NEW.photoID, NEW.rings, NEW.descript, NEW.species, NEW.height);
        END;
