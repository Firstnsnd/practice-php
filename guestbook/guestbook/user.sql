/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50713
Source Host           : localhost:3306
Source Database       : guestbook

Target Server Type    : MYSQL
Target Server Version : 50713
File Encoding         : 65001

Date: 2016-08-16 15:03:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `level` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET FOREIGN_KEY_CHECKS=1;
INSERT INTO user(nickname, password, createtime, level)    values( 'shiyanlou','21232f297a57a5a743894a0e4a801fc3', 1423018916, 9);