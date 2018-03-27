/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : ajaxdemo

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-08-31 13:03:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for courses
-- ----------------------------
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `coursesid` int(11) NOT NULL AUTO_INCREMENT COMMENT '课程id',
  `coursesname` varchar(255) DEFAULT NULL COMMENT '课程名称',
  `coursesprice` varchar(255) DEFAULT NULL COMMENT '课程价格',
  `coursesintro` varchar(255) DEFAULT NULL COMMENT '课程简介',
  `coursescontent` text COMMENT '课程内容',
  `coursestime` datetime DEFAULT NULL COMMENT '加入时间',
  `coursesuser` varchar(255) DEFAULT NULL,
  `courseimg` varchar(255) DEFAULT NULL COMMENT '课程小图片',
  PRIMARY KEY (`coursesid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of courses
-- ----------------------------
INSERT INTO `courses` VALUES ('1', 'php使用ob函数页面静态化', '1000', '随着网站用户量和内容量的增加，一直使用动态语言会对服务器和数据库存在很大的压力，因此在大中型网站对于网站优化越来越看重，动态页面静态化就是网站优化的一个大的方向。网站静态化分为\r\n伪静态和真静态，在真静态中又分为全部纯静态和局部纯静态，我们本次实验主要为页面全部纯静态。', '一、加快页面打开浏览速度，静态页面无需连接数据库打开速度较动态页面有明显提高；\r\n二、有利于搜索引擎优化SEO，Baidu、Google都会优先收录静态页面，不仅被收录的快还收录的全；\r\n三、减轻服务器负担，浏览网页无需调用系统数据库；\r\n四、网站更安全，HTML页面不会受php相关漏洞的影响； 观看一下大一点的网站基本全是静态页面，而且可以减少攻击，防sql注入。\r\n\r\n', '2016-08-24 11:20:27', '无树', './images/jingtai.jpg');
INSERT INTO `courses` VALUES ('2', 'PHP 实现简单的 MVC 框架', '1000', '本课程将使用 PHP 实现一个简单的 MVC 框架，包含模型、视图、控制器以及模板解析等部分。了解MVC框架的基本原理和运行流程，学习面向对象编程和MVC设计模式，并学习开发中的一些注意事项。', '本课程将使用 PHP 实现一个简单的 MVC 框架，包含模型、视图、控制器以及模板解析等部分。了解MVC框架的基本原理和运行流程，学习面向对象编程和MVC设计模式，并学习开发中的一些注意事项。', '2016-08-24 17:02:56', '无树', './images/a1.jpg');
INSERT INTO `courses` VALUES ('3', 'PHP 实现用户注册登录功能', '1000', '本课程通过使用 PHP 及 Web 前端技术实现一个网站注册登录入口页面，学习并实践 PHP 编程，GD库，MySQL 扩展，Bootstrap 响应式布局，Cookie/Session 及 Ajax 等知识点。', '本课程通过使用 PHP 及 Web 前端技术实现一个网站注册登录入口页面，学习并实践 PHP 编程，GD库，MySQL 扩展，Bootstrap 响应式布局，Cookie/Session 及 Ajax 等知识点。', '2016-08-24 17:03:44', '无树', './images/a2.jpg');
INSERT INTO `courses` VALUES ('4', ' 校花评比排名项目-PHP', '1000', '分析利用《社交网络》中评比算法，通过两两美女之间比较，计算出颜值，得出美女排名。PHP结合前端相关技术实现。', '分析利用《社交网络》中评比算法，通过两两美女之间比较，计算出颜值，得出美女排名。PHP结合前端相关技术实现。', '2016-08-24 17:04:30', '无树', './images/a5.jpg');
INSERT INTO `courses` VALUES ('5', 'PHP编程语言', '1000', 'PHP是一种被广泛应用的开放源代码的多用途脚本语言，它可嵌入到 HTML中，尤其适合 web 开发。实验课程基于《PHP 参考手册》中文版本制作。', 'PHP是一种被广泛应用的开放源代码的多用途脚本语言，它可嵌入到 HTML中，尤其适合 web 开发。实验课程基于《PHP 参考手册》中文版本制作。', '2016-08-24 17:05:07', '无树', null);
INSERT INTO `courses` VALUES ('6', 'Linux 基础入门（新版）', '1000', '要在实验楼愉快地学习，先要熟练地使用 Linux，本实验介绍 Linux 基本操作，shell 环境下的常用命令。', '要在实验楼愉快地学习，先要熟练地使用 Linux，本实验介绍 Linux 基本操作，shell 环境下的常用命令。', '2016-08-24 17:05:07', '无树', null);
INSERT INTO `courses` VALUES ('7', '动手实战学Docker', '1000', '15个实验带你体验Docker魅力，最快的上手教程，最新的技术领域，最多的动手实践。在线实验学习Docker，DockerFile，Compose，Swarm，Kubernetes等技术。价格199元，年会员8折，购买可赠一个月的会员。', '15个实验带你体验Docker魅力，最快的上手教程，最新的技术领域，最多的动手实践。在线实验学习Docker，DockerFile，Compose，Swarm，Kubernetes等技术。价格199元，年会员8折，购买可赠一个月的会员。', '2016-08-25 09:53:46', '无树', null);
INSERT INTO `courses` VALUES ('8', '1小时入门增强现实技术', '1000', '仅需C+＋语言基础，本课程将基于OpenCV实现一个将3D模型显示在现实中的小例子，学习基于Marker的AR技术，既简单又有趣。', '仅需C+＋语言基础，本课程将基于OpenCV实现一个将3D模型显示在现实中的小例子，学习基于Marker的AR技术，既简单又有趣。', '2016-08-25 09:54:15', '无树', null);
INSERT INTO `courses` VALUES ('9', ' C++ 开发 Web 服务框架', '1000', ' C++ 开发 Web 服务框架', ' C++ 开发 Web 服务框架', '2016-08-25 09:54:33', '无树', null);
INSERT INTO `courses` VALUES ('10', 'C++ 实现高性能内存池', '1000', '获得内存池所分配的内存速度高于从堆中获得分配的内存的速度，一个长期稳定运行的服务在追求极致的过程中，实现内存池是必不可少的。和标准库中的默认分配器一样，内存池本质上也是分配器，本次实验将设计并使用 C++实现一个高性能内存池。', '获得内存池所分配的内存速度高于从堆中获得分配的内存的速度，一个长期稳定运行的服务在追求极致的过程中，实现内存池是必不可少的。和标准库中的默认分配器一样，内存池本质上也是分配器，本次实验将设计并使用 C++实现一个高性能内存池。', '2016-08-25 09:54:57', '无树', null);
INSERT INTO `courses` VALUES ('11', 'C++ 实现太阳系行星系统', '1000', '使用 C++实现 OpenGL GLUT 实现一个简单的太阳系行星系统，将涉及一些三维图形技术的数学基础、OpenGL 里的三维坐标系、OpenGL 里的光照模型、GLUT 的键盘事件处理。', '使用 C++实现 OpenGL GLUT 实现一个简单的太阳系行星系统，将涉及一些三维图形技术的数学基础、OpenGL 里的三维坐标系、OpenGL 里的光照模型、GLUT 的键盘事件处理。', '2016-08-25 09:55:22', '无树', null);
