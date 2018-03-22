create database ajaxdemo default charset utf8;
use ajaxdemo;
CREATE TABLE `ajaxtest` (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `userpass` varchar(50) NOT NULL COMMENT '密码',
  `userage` int(11) NOT NULL COMMENT '年龄',
  `usersex` varchar(1) NOT NULL COMMENT '性别',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `ajaxtest` VALUES ('1','李四', 'lisi', '15', '男'); #插条数据
INSERT INTO `ajaxtest` VALUES ('2','张三', 'lisi', '20', '男'); #插入数据
INSERT INTO `ajaxtest` VALUES ('3','王五', 'lisi', '25', '男'); #插入数据
INSERT INTO `ajaxtest` VALUES ('4','韩梅梅', 'lisi', '25', '女'); #插入数据
INSERT INTO `ajaxtest` VALUES ('5','张莉', 'lisi', '25', '女'); #插入数据
truncate ajaxtest;
INSERT INTO `ajaxtest` VALUES ('1', 'lisi', 'lisi', '15', '男');
INSERT INTO `ajaxtest` VALUES ('2', 'zhangsan', 'lisi', '20', '男');
INSERT INTO `ajaxtest` VALUES ('3', 'wangwu', 'lisi', '25', '男');
INSERT INTO `ajaxtest` VALUES ('4', 'hanmeimei', 'lisi', '25', '女');
INSERT INTO `ajaxtest` VALUES ('5', 'zhangli', 'lisi', '25', '女');