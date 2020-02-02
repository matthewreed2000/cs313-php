CREATE TABLE User (
   ID          SERIAL         NOT NULL PRIMARY KEY,
   Username    VARCHAR(100)   NOT NULL UNIQUE,
   Password    VARCHAR(100)   NOT NULL,
   DisplayName VARCHAR(100)   NOT NULL
);

CREATE TABLE Task (
   ID          SERIAL         NOT NULL PRIMARY KEY,
   Title       VARCHAR(100)   NOT NULL,
   Description TEXT,
   Priority    INT            DEFAULT 0 
);

CREATE TABLE Repeat (
   ID          SERIAL      NOT NULL PRIMARY KEY,
   Pattern     VARCHAR(10) NOT NULL,
   StartTime   SMALLINT    DEFAULT 0,
   EndTime     SMALLINT    DEFAULT 1439,
   StartDate   DATE        DEFAULT GETDATE(),
   EndDate     DATE        DEFAULT GETDATE()
);

CREATE TABLE DateTask (
   ID       SERIAL   NOT NULL PRIMARY KEY,
   SetDate  DATE,
   TaskID            NOT NULL REFERENCES Task(ID),
   RepeatID          NOT NULL REFERENCES Repeat(ID)
);

CREATE TABLE UserDateTask (
   ID       SERIAL   NOT NULL PRIMARY KEY,
   UserID            NOT NULL REFERENCES User(ID),
   DateTaskID        NOT NULL REFERENCES DateTask(ID)
);