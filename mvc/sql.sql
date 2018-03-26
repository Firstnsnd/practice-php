CREATE DATABASE IF NOT EXISTS labframe;
USE labframe;
CREATE TABLE lab_user(
  `id` INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL
);
INSERT INTO lab_user (name,password) VALUES ('admin','shiyanlou');