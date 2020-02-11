DROP TABLE IF EXISTS scripture_topic;
DROP TABLE IF EXISTS topic;

CREATE TABLE topic (
   id    SERIAL         NOT NULL PRIMARY KEY,
   name  VARCHAR(100)   NOT NULL
);

CREATE TABLE scripture_topic (
   id SERIAL NOT NULL PRIMARY KEY,
   topic_id INT NOT NULL REFERENCES topic(id),
   scripture_id INT NOT NULL REFERENCES scripture(id)
);
