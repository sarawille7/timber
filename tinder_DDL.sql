.mode columns
.headers on
.nullvalue NULL
PRAGMA foreign_keys = ON;

CREATE TABLE Users(
    username TEXT PRIMARY KEY,
    password TEXT NOT NULL,
    privileges TEXT NOT NULL CHECK(privileges IN ("general", "admin")) --all lowercase
);

--Used for containing possible tree species a user can input
CREATE TABLE PossibleSpecies(
    species TEXT UNIQUE
);
--treeID, username, name, photoID, rings, descript, species, height
CREATE TABLE Trees(
    treeID INTEGER PRIMARY KEY,
    username TEXT NOT NULL,
    name TEXT NOT NULL,
    photoID INTEGER NOT NULL UNIQUE,
    rings INTEGER NOT NULL CHECK,
    descript TEXT NOT NULL CHECK(LENGTH(descript) < 280),
    species TEXT NOT NULL,
    height REAL NOT NULL CHECK,
    FOREIGN KEY (username)
        REFERENCES Users (username)
          ON UPDATE CASCADE
          ON DELETE CASCADE
    FOREIGN KEY (species)
        REFERENCES PossibleSpecies(species)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

CREATE TABLE Matches(
    username TEXT NOT NULL,
    treeID INTEGER NOT NULL,
    matchDate TIMESTAMP NOT NULL,
    PRIMARY KEY (username, treeID)
    FOREIGN KEY (username)
        REFERENCES Users (username)
          ON UPDATE CASCADE
          ON DELETE CASCADE
    FOREIGN KEY (treeID)
        REFERENCES Trees (treeID)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

CREATE TABLE Banned(
    username ATE UNIQUE,
    banDate TIMESTAMP NOT NULL,
    FOREIGN KEY (username)
        REFERENCES Users (username)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

CREATE TABLE UserActivity(
    event TEXT CHECK(event IN ("Deletion", "Insertion", "Update")),
    eventTime TIMESTAMP,
    username TEXT,
    oldPassword TEXT,
    oldPrivileges TEXT,
    newPassword TEXT,
    newPrivileges TEXT,
    PRIMARY KEY (username, eventTime)
    FOREIGN KEY (username)
        REFERENCES Users (username)
            ON UPDATE CASCADE
            ON UPDATE CASCADE
);

CREATE TABLE TreeActivity(
    event TEXT CHECK(event IN ("Deletion", "Insertion", "Update")),
    eventTime TIMESTAMP,
    treeID INTEGER,
    oldName TEXT,
    oldPhotoID INTEGER,
    oldRings INTEGER,
    oldDescript TEXT,
    oldSpecies TEXT,
    oldHeight REAL,
    newName TEXT,
    newPhotoID INTEGER,
    newRings INTEGER,
    newDescript TEXT,
    newSpecies TEXT,
    newHeight REAL,
    PRIMARY KEY (treeID, eventTime)
    FOREIGN KEY (treeID)
        REFERENCES Trees (treeID)
            ON UPDATE CASCADE
            ON UPDATE CASCADE
);

CREATE TABLE SpeciesActivity(
    event TEXT CHECK(event IN ("Deletion", "Insertion", "Update")),
    eventTime TIMESTAMP,
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
            VALUES ('Deletion', datetime('now'), OLD.username, OLD.password, OLD.privileges, null, null);
        END;

CREATE TRIGGER UserEvent_insert
    AFTER DELETE ON Users
        BEGIN
            INSERT INTO UserActivity
            VALUES ('Insertion', datetime('now'), NEW.username, null, null, NEW.password, NEW.privileges);
        END;

CREATE TRIGGER UserEvent_update
    AFTER DELETE ON Users
        BEGIN
            INSERT INTO UserActivity
            VALUES ('Insertion', datetime('now'), OLD.username, OLD.password, OLD.privileges, NEW.password, NEW.privileges);
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
