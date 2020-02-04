DROP TABLE IF EXISTS week05family;
DROP TABLE IF EXISTS week05rel;

CREATE TABLE week05rel (
   id SERIAL NOT NULL PRIMARY KEY,
   description VARCHAR(100) NOT NULL
);

CREATE TABLE week05family (
   id SERIAL NOT NULL PRIMARY KEY,
   first_name VARCHAR(100) NOT NULL,
   last_name VARCHAR(100) NOT NULL,
   relationship INT NOT NULL REFERENCES week05rel(id)
);

INSERT INTO week05rel (description) VALUES ('Mother');
INSERT INTO week05rel (description) VALUES ('Father');
INSERT INTO week05rel (description) VALUES ('Sister');
INSERT INTO week05rel (description) VALUES ('Brother');
INSERT INTO week05rel (description) VALUES ('In-Law');
INSERT INTO week05rel (description) VALUES ('Niece');
INSERT INTO week05rel (description) VALUES ('Nephew');

INSERT INTO week05family ( first_name,
                           last_name,
                           relationship)
                  VALUES ( 'Debi',
                           'Reed',
                           1);
INSERT INTO week05family ( first_name,
                           last_name,
                           relationship)
                  VALUES ( 'Curtis',
                           'Reed',
                           2);
INSERT INTO week05family ( first_name,
                           last_name,
                           relationship)
                  VALUES ( 'Becky',
                           'Dzierson',
                           3);
INSERT INTO week05family ( first_name,
                           last_name,
                           relationship)
                  VALUES ( 'Melody',
                           'Richards',
                           3);
INSERT INTO week05family ( first_name,
                           last_name,
                           relationship)
                  VALUES ( 'Michael',
                           'Reed',
                           4);
INSERT INTO week05family ( first_name,
                           last_name,
                           relationship)
                  VALUES ( 'Lisa',
                           'Dzierson',
                           3);