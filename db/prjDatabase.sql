DROP TABLE IF EXISTS UserTask;
DROP TABLE IF EXISTS Task;
DROP TABLE IF EXISTS Repeat;
DROP TABLE IF EXISTS UserData;

-- User Information
CREATE TABLE UserData (
   ID          SERIAL         NOT NULL PRIMARY KEY,
   Username    VARCHAR(100)   NOT NULL UNIQUE,
   Password    VARCHAR(100)   NOT NULL,
   DisplayName VARCHAR(100)   NOT NULL
);

-- Patterns for Task Repetition
CREATE TABLE Repeat (
   ID       SERIAL      NOT NULL PRIMARY KEY,
   Pattern  VARCHAR(10) NOT NULL,
   EndDate  DATE
);

-- Task
CREATE TABLE Task (
   ID             SERIAL         NOT NULL PRIMARY KEY,
   Title          VARCHAR(100)   NOT NULL,
   Description    TEXT,
   SetDate        DATE           DEFAULT NOW(),
   EndDateOffset  INT            DEFAULT 0,
   StartTime      SMALLINT       DEFAULT 0,
   EndTime        SMALLINT       DEFAULT 1439,
   Priority       INT            DEFAULT 0,
   RepeatID       INT,
   FOREIGN KEY (RepeatID)
      REFERENCES Repeat(ID)
      ON DELETE SET NULL
);

-- Connects tasks to user and sets date
CREATE TABLE UserTask (
   ID       SERIAL   NOT NULL PRIMARY KEY,
   UserID   INT      NOT NULL,
   TaskID   INT      NOT NULL,
   FOREIGN KEY (UserID)
      REFERENCES UserData(ID)
      ON DELETE CASCADE,
   FOREIGN KEY (TaskID)
      REFERENCES Task(ID)
      ON DELETE CASCADE
);

-- These may be changed later if I find a better way of organizing.


-- Testing Some Values
INSERT INTO UserData (username, password, displayname)
VALUES ('test', 'test123', 'Test User');

INSERT INTO UserData (username, password, displayname)
VALUES ('ree18008', 'password', 'Matthew Reed');

INSERT INTO UserData (username, password, displayname)
VALUES ('brobirch', '123456', 'Bro Birch');

-- This would be weekly on thursdays until March 03
INSERT INTO Repeat (Pattern, EndDate)
VALUES ('wR', '2020_03_03');

INSERT INTO Task (title)
VALUES ('Matthew`s Task');

INSERT INTO Task (title)
VALUES ('Test Task');

INSERT INTO Task (title, Description, SetDate)
VALUES ('Test Task Desc', 'This is a description', '2020_02_26');

-- This would be from 8:00 AM to 8:00 PM
INSERT INTO Task (Title, Description, SetDate, StartTime, EndTime)
VALUES ('Test Task Time', 'This is a test with a start and end time', '2020_02_15', 480, 1200);

INSERT INTO Task (Title, Description, SetDate, RepeatID)
VALUES ('Test Task Repeat', 'This should repeat', '2020_02_19', 1);

INSERT INTO Task (title, Description, EndDateOffset, StartTime, EndTime, Priority, RepeatID)
VALUES ('Test Task All', 'This is all the things', 1, 0, 120, 10, 1);

INSERT INTO UserTask (UserId, TaskID)
VALUES (1, 2);

INSERT INTO UserTask (UserId, TaskID)
VALUES (2, 1);

INSERT INTO UserTask (UserId, TaskID)
VALUES (1, 3);

INSERT INTO UserTask (UserId, TaskID)
VALUES (1, 4);

INSERT INTO UserTask (UserId, TaskID)
VALUES (1, 5);