DROP TABLE IF EXISTS PUBLIC.UserTask;
DROP TABLE IF EXISTS PUBLIC.Task;
DROP TABLE IF EXISTS PUBLIC.Repeat;
DROP TABLE IF EXISTS PUBLIC.User;

-- User Information
CREATE TABLE PUBLIC.User (
   ID          SERIAL         NOT NULL PRIMARY KEY,
   Username    VARCHAR(100)   NOT NULL UNIQUE,
   Password    VARCHAR(100)   NOT NULL,
   DisplayName VARCHAR(100)   NOT NULL
);

-- Patterns for Task Repetition
CREATE TABLE PUBLIC.Repeat (
   ID       SERIAL      NOT NULL PRIMARY KEY,
   Pattern  VARCHAR(10) NOT NULL,
   EndDate  DATE
);

-- Task
CREATE TABLE PUBLIC.Task (
   ID             SERIAL         NOT NULL PRIMARY KEY,
   Title          VARCHAR(100)   NOT NULL,
   Description    TEXT,
   EndDateOffset  INT            DEFAULT 0,
   StartTime      SMALLINT       DEFAULT 0,
   EndTime        SMALLINT       DEFAULT 1439,
   Priority       INT            DEFAULT 0,
   RepeatID       INT,
   FOREIGN KEY (RepeatID)
      REFERENCES PUBLIC.Repeat(ID)
      ON DELETE SET NULL
);

-- Connects tasks to user and sets date
CREATE TABLE PUBLIC.UserTask (
   ID       SERIAL   NOT NULL PRIMARY KEY,
   UserID   INT      NOT NULL,
   TaskID   INT      NOT NULL,
   SetDate  DATE     DEFAULT NOW(),
   FOREIGN KEY (UserID)
      REFERENCES PUBLIC.User(ID)
      ON DELETE CASCADE,
   FOREIGN KEY (TaskID)
      REFERENCES PUBLIC.Task(ID)
      ON DELETE CASCADE
);

-- These may be changed later if I find a better way of organizing.


-- Testing Some Values
INSERT INTO public.User (username, password, displayname)
VALUES ('test', 'test123', 'Test User');

INSERT INTO public.User (username, password, displayname)
VALUES ('ree18008', 'password', 'Matthew Reed');

INSERT INTO public.User (username, password, displayname)
VALUES ('brobirch', '123456', 'Bro Birch');

-- This would be weekly on thursdays until March 03
INSERT INTO public.Repeat (Pattern, EndDate)
VALUES ('wR', '2020_03_03');

INSERT INTO public.Task (title)
VALUES ('Matthew`s Task');

INSERT INTO public.Task (title)
VALUES ('Test Task');

INSERT INTO public.Task (title, Description)
VALUES ('Test Task Desc', 'This is a description');

-- This would be from 8:00 AM to 8:00 PM
INSERT INTO public.Task (Title, Description, StartTime, EndTime)
VALUES ('Test Task Time', 'This is a test with a start and end time', 480, 1200);

INSERT INTO public.Task (Title, Description, RepeatID)
VALUES ('Test Task Repeat', 'This should repeat', 1);

INSERT INTO public.Task (title, Description, EndDateOffset, StartTime, EndTime, Priority, RepeatID)
VALUES ('Test Task All', 'This is all the things', 1, 0, 120, 10, 1);

INSERT INTO public.UserTask (UserId, TaskID)
VALUES (1, 2);

INSERT INTO public.UserTask (UserId, TaskID)
VALUES (2, 1);

INSERT INTO public.UserTask (UserId, TaskID, SetDate)
VALUES (1, 3, '2020_02_26');

INSERT INTO public.UserTask (UserId, TaskID, SetDate)
VALUES (1, 4, '2020_02_15');

INSERT INTO public.UserTask (UserId, TaskID, SetDate)
VALUES (1, 5, '2020_02_19');