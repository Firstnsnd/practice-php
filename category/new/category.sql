create database category default charset utf8;
use category;


CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动增长id',
  `pid` int(11) NOT NULL COMMENT '父id',
  `category` varchar(255) NOT NULL COMMENT '分类名称',
  `orderid` int(11) NOT NULL DEFAULT '0' COMMENT '排序id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

