CREATE DATABASE produkty;
use produkty;
CREATE TABLE `item` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(64) NOT NULL,
  `cost_price` decimal(7,2) DEFAULT NULL,
  `sell_price` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO `item` (`item_id`,`description`,`cost_price`,`sell_price`) VALUES
 (1,'Wood Puzzle','15.23','21.95'),
 (2,'Rubik Cube','7.45','11.49'),
 (3,'Linux CD','1.99','2.49'),
 (4,'Tissues','2.11','3.99'),
 (5,'Picture Frame','7.54','9.95'),
 (6,'Fan Small','9.23','15.75'),
 (7,'Fan Large','13.36','19.95'),
 (8,'Toothbrush','0.75','1.45'),
 (9,'Roman Coin','2.34','2.45'),
 (10,'Carrier Bag','0.01','0.00'),
 (11,'Speakers','19.73','25.32'),
 (12,'SQL Server 2005',NULL,NULL);
