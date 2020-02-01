-- CREATE DATABASE conference;

-- \c conference

CREATE TABLE public.user (
   id             SERIAL         NOT NULL    PRIMARY KEY,
   username       VARCHAR(100)   NOT NULL    UNIQUE,
   password       VARCHAR(100)   NOT NULL,
   display_name   VARCHAR(100)   NOT NULL
);

CREATE TABLE public.speaker (
   id    SERIAL         NOT NULL PRIMARY KEY,
   name  VARCHAR(100)   NOT NULL
);

CREATE TABLE public.conference (
   id          SERIAL   NOT NULL PRIMARY KEY,
   year        SMALLINT NOT NULL,
   is_saturday BOOLEAN  NOT NULL,
   is_morning  BOOLEAN  NOT NULL,
   is_spring   BOOLEAN  NOT NULL
);

CREATE TABLE public.talk (
   id             SERIAL         NOT NULL PRIMARY KEY,
   speaker_id     INT            NOT NULL REFERENCES public.speaker(id),
   conference_id  INT            NOT NULL REFERENCES public.conference(id),
   title          VARCHAR(100)
);

CREATE TABLE public.note (
   id          SERIAL   NOT NULL PRIMARY KEY,
   user_id     INT      NOT NULL REFERENCES public.speaker(id),
   talk_id     INT      NOT NULL REFERENCES public.talk(id),
   note_text   TEXT     NOT NULL
);

INSERT INTO public.user (username, password, display_name)
VALUES ('elkinty', 'february', 'Tyler Elkington');

INSERT INTO public.speaker (name)
VALUES ('Elder Bednar');

INSERT INTO public.conference (year, is_saturday, is_morning, is_spring)
VALUES (2019, TRUE, FALSE, FALSE);

INSERT INTO public.talk (speaker_id, conference_id, title)
VALUES (1, 1, 'Watchful unto Prayer Continually');

INSERT INTO public.talk (speaker_id, conference_id, title)
VALUES (1, 1, 'Something Else');

INSERT INTO public.note (user_id, talk_id, note_text)
VALUES (1, 1, 'This is a note');

INSERT INTO public.note (user_id, talk_id, note_text)
VALUES (1, 2, 'This is a note');

SELECT * FROM note WHERE talk_id = 1 AND user_id = 1;


DROP TABLE public.note;
DROP TABLE public.talk;
DROP TABLE public.conference;
DROP TABLE public.speaker;
DROP TABLE public.user;