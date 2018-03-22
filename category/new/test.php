<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-21
 * Time: 下午4:52
 */
header("Content-type: text/html; charset=utf-8"); //注意，一定要加上这一句，不然在浏览器中可能会显示乱码
//包含数据库连接文件
require_once('./db.php');
//得到数据库连接，我们可以直接使用类文件中的子方法，是不必实例化这个类
$conn = db::getInstance()->connect();
//执行数据库查询，使用query方法来执行SQL语句
$result = $conn->query("select * from category");
//显示到页面上的例子，执行后会得到一个对象，使用while循环得到我们数据。
while($row=$result->fetch_assoc()){
    echo $row['id']."+".$row['category']."<br />";
}
