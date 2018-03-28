#web 数据库，users 表：id，username，email，password
CREATE DATABASE  `web`;
USE `web`;
# 可使用以下 SQL 语句建立数据表:
CREATE TABLE users(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password CHAR(32) NOT NULL
);