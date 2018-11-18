BEGIN TRANSACTION;

SELECT 'Phase 1, Testing for valid and invalid entries';

--Users: username, password, privileges
SELECT '...USERS TESTS...';
    SELECT 'VALID USERS (3 tests)';
        INSERT INTO Users VALUES('testUser', 'securehash', 'general');
        INSERT INTO Users VALUES('testUser2', 'password', 'general');
        INSERT INTO Users VALUES('testAdmin', 'encryption', 'admin');

    SELECT 'A REPEAT OF A USERNAME SHOULD FAIL (2 tests)';
        INSERT INTO Users VALUES('testUser', 'repeated', 'general');
        INSERT INTO Users VALUES('testUser', 'repeated', 'admin');

    SELECT 'INVALID PRIVILEGES LABEL SHOULD FAIL (1 test)';
        INSERT INTO Users VALUES('privilegesTest', 'failure', 'nope');

    SELECT 'NO NULLS ARE PERMITTED (3 tests)';
        INSERT INTO Users VALUES(NULL, 'userIsNull', 'general');
        INSERT INTO Users VALUES('passIsNull', NULL, 'general');
        INSERT INTO Users VALUES('privilegesAreNull', 'failure', NULL);

SELECT '...POSSIBLE SPECIES TESTS...';
    SELECT 'ACCEPTABLE VALUES (1 test)';
        INSERT INTO PossibleSpecies VALUES('Pine');

    SELECT 'REPEATS NOT ALLOWED (1 test)';
        INSERT INTO PossibleSpecies VALUES('Pine');

    SELECT 'NULL NOT ALLOWED (1 test)';
        INSERT INTO PossibleSpecies VALUES(NULL);

--Trees: treeID, username, name, photoID, rings, descript, species, height
SELECT '...TREES TESTS...';
    SELECT 'ACCEPTABLE VALUES (2 tests)';
        INSERT INTO Trees VALUES(0, 'testUser', 'Sheryl', 0, 18, 'body of text', 'Pine', 10.0);
        INSERT INTO Trees VALUES(1888, 'testUser2', 'Lenny', 1888, 'textual content', 'Pine', 12.8);

    SELECT 'REPEATED treeID NOT ALLOWED (1 test)';
        INSERT INTO Trees VALUES(0, 'testUser2', 'Larry', 404, 404, 'text body', 'Pine', 40.4);

    SELECT 'REPEATED photoID NOT ALLOWED (1 test)';
        INSERT INTO Trees VALUES(404, 'testUser', 'Kenneth', 0, 404, 'text body', 'Pine', 40.4);

    SELECT 'PERMIT NO NULLS (8 tests)';
        INSERT INTO Trees VALUES(NULL, 'testUser', 'Sheryl',1,    18,   'body of text', 'Pine', 10.0);
        INSERT INTO Trees VALUES(1,    NULL,       'Larry', 2,    18,   'body of text', 'Pine', 10.0);
        INSERT INTO Trees VALUES(2,    'testUser', NULL,    3,    18,   'body of text', 'Pine', 10.0);
        INSERT INTO Trees VALUES(3,    'testUser', 'Larry', NULL, 18,   'body of text', 'Pine', 10.0);
        INSERT INTO Trees VALUES(4,    'testUser', 'Larry', 4,    NULL, 'body of text', 'Pine', 10.0);
        INSERT INTO Trees VALUES(5,    'testUser', 'Larry', 5,    18,   NULL,           'Pine', 10.0);
        INSERT INTO Trees VALUES(6,    'testUser', 'Larry', 6,    18,   'body of text', NULL,   10.0);
        INSERT INTO Trees VALUES(7,    'testUser', 'Larry', 7,    18,   'body of text', 'Pine', NULL);

--username, treeID, matchDate
  SELECT '...MATCHES TESTS...';
      SELECT 'ACCEPTABLE VALUES (1 test)';
        INSERT INTO Matches VALUES('testUser2', 0, datetime('now'));
      SELECT 'NULL NOT ALLOWED (3 tests)';
        INSERT INTO Matches VALUES(NULL, 0, datetime('now'));
        INSERT INTO Matches VALUES('testUser', NULL, datetime('now'));
          INSERT INTO Matches VALUES('testUser', 1888, NULL);

ROLLBACK;

SELECT 'Phase 2, Dummy Data Entry';
INSERT INTO PossibleSpecies VALUES('Pine');
INSERT INTO PossibleSpecies VALUES('Birch');
INSERT INTO PossibleSpecies VALUES('Oak');

INSERT INTO Users VALUES('a', 'p4ssw0rd', 'general');
INSERT INTO Users VALUES('b', 'password', 'general');
INSERT INTO Users VALUES('c', 'secure', 'admin');

INSERT INTO Trees VALUES(0, 'a', 'a pine', 0, 18, 'a description of a pine', 'Pine', 118.0);
INSERT INTO Trees VALUES(1, 'a', 'a birch', 1, 27, 'a description of a birch', 'Birch', 201.0);

INSERT INTO Trees VALUES(2, 'b', 'b pine', 2, 18, 'a description of b pine', 'Pine', 118.0);
INSERT INTO Trees VALUES(3, 'b', 'b oak', 3, 20, 'a description of b oak', 'Oak', 101.0);

INSERT INTO Matches VALUES('a' 2, datetime('now'));
INSERT INTO Matches VALUES('a' 3, datetime('now'));
INSERT INTO Matches VALUES('b' 0, datetime('now'));

INSERT INTO Banned VALUES('b', datetime('now'));
