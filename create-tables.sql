DROP DATABASE IF EXISTS judger;
CREATE DATABASE judger;
USE judger;
CREATE TABLE user(`id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `user` (`username`, `password`) VALUES 
    ('kai', '123456'),
    ('foo', '123456'),
    ('bar', '123456');
