<?php
/**
 *测试模板引擎
 * @authors Your Name (you@example.org)
 * @date    2016-05-24 19:54:29
 * @version $Id$
 */
include 'Template.php';
$tpl=new Template( array('php_turn' =>true,'debug'=>true));
$tpl->assign('data','hello world');
$tpl->assign('person','cafeCAT');
$tpl->assign('pai',3.14);
$arr=array(1,2,3,4,"hahattt",6);
$tpl->show('member');
