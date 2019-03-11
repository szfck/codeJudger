DROP DATABASE IF EXISTS judger;
CREATE DATABASE judger;
USE judger;
CREATE TABLE user(`id` int NOT NULL AUTO_INCREMENT,
  `useremail` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `user` (`useremail`, `username`, `password`) VALUES 
    ('hello@codejudger.com', 'kai', '123456');
