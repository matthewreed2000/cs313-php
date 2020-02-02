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
   RepeatID       INT            REFERENCES PUBLIC.Repeat(ID)
);

-- Connects tasks to user and sets date
CREATE TABLE PUBLIC.UserTask (
   ID       SERIAL   NOT NULL PRIMARY KEY,
   UserID   INT      NOT NULL REFERENCES PUBLIC.User(ID),
   TaskID   INT      NOT NULL REFERENCES PUBLIC.Task(ID),
   SetDate  DATE     DEFAULT NOW()
);

-- These may be changed later if I find a better way of organizing.


-- Testing Some Values
INSERT INTO public.User (username, password, displayname)
VALUES ('ree18008', 'password', 'Matthew Reed');

INSERT INTO public.User (username, password, displayname)
VALUES ('brobirch', '123456', 'Bro Birch');

INSERT INTO public.Task (title)
VALUES ('Test task');

-- This would be weekly on thursdays until March 03
INSERT INTO public.Repeat (Pattern, EndDate)
VALUES ('wR', '2020-03-03');

-- This would be from 8:00 AM to 8:00 PM
INSERT INTO public.Task (Title, Description, StartTime, EndTime)
VALUES ('Task Thing', 'This is a test task also', 480, 1200);

INSERT INTO public.UserTask (UserId, TaskID)
VALUES (1, 2);