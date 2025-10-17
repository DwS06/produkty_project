use produkty;

CREATE OR REPLACE USER 'user1'@'localhost' IDENTIFIED BY 'user1';
GRANT SELECT ON produkty.* TO 'user1'@'localhost';

CREATE OR REPLACE USER 'user2'@'localhost' IDENTIFIED BY 'user2';
GRANT ALL PRIVILEGES ON produkty.* TO 'user2'@'localhost';