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
INSERT INTO `user` (`useremail`, `username`, `password`) VALUES 
    ('rj1234@nyu.edu', 'rajeev', 'e10adc3949ba59abbe56e057f20f883e');

CREATE TABLE submission(`subid` int NOT NULL AUTO_INCREMENT,
  `time` int NOT NULL,
  `problem` varchar(100) NOT NULL,
  `userid` int NOT NULL,
  `filename` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `result` varchar(100) NOT NULL,
  PRIMARY KEY (`subid`)
);
INSERT INTO `submission` (`time`, `problem`, `userid`, `filename`, `type`, `result`) VALUES 
    ('1234567', 'add', 0, '0.cpp', 'cpp', 'pending');
