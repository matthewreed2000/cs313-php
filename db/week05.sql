DROP TABLE IF EXISTS w5_family_members;
DROP TABLE IF EXISTS w5_relationships;

CREATE TABLE w5_relationships (
   id SERIAL NOT NULL PRIMARY KEY,
   description VARCHAR(100) NOT NULL
);

CREATE TABLE w5_family_members (
   id SERIAL NOT NULL PRIMARY KEY,
   first_name VARCHAR(100) NOT NULL,
   last_name VARCHAR(100) NOT NULL,
   relationship_id INT NOT NULL REFERENCES w5_relationships(id)
);

INSERT INTO w5_relationships (description) VALUES ('Mother');
INSERT INTO w5_relationships (description) VALUES ('Father');
INSERT INTO w5_relationships (description) VALUES ('Sister');
INSERT INTO w5_relationships (description) VALUES ('Brother');
INSERT INTO w5_relationships (description) VALUES ('In-Law');
INSERT INTO w5_relationships (description) VALUES ('Niece');
INSERT INTO w5_relationships (description) VALUES ('Nephew');

INSERT INTO w5_family_members ( first_name,
                           last_name,
                           relationship_id)
                  VALUES ( 'Debi',
                           'Reed',
                           1);
INSERT INTO w5_family_members ( first_name,
                           last_name,
                           relationship_id)
                  VALUES ( 'Curtis',
                           'Reed',
                           2);
INSERT INTO w5_family_members ( first_name,
                           last_name,
                           relationship_id)
                  VALUES ( 'Becky',
                           'Dzierson',
                           3);
INSERT INTO w5_family_members ( first_name,
                           last_name,
                           relationship_id)
                  VALUES ( 'Melody',
                           'Richards',
                           3);
INSERT INTO w5_family_members ( first_name,
                           last_name,
                           relationship_id)
                  VALUES ( 'Michael',
                           'Reed',
                           4);
INSERT INTO w5_family_members ( first_name,
                           last_name,
                           relationship_id)
                  VALUES ( 'Lisa',
                           'Dzierson',
                           3);