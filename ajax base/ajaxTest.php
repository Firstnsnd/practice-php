<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-22
 * Time: 上午10:31
 */
error_reporting(0); //不显示警告信息
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "123456";
$dbname = "ajaxdemo";

$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

$mysqli->query("SET NAMES 'UTF8'"); //页面输出的汉字不会乱码

$userage = $_GET['userage'];
$usersex = $_GET['usersex'];


$userage = $mysqli->real_escape_string($userage);
$usersex = $mysqli->real_escape_string($usersex);

$query = "SELECT * FROM ajaxtest WHERE usersex = '$usersex'";

if(is_numeric($userage))
    $query .= " AND userage <= $userage ;";

$qry_result = $mysqli->query($query);


if ($qry_result->num_rows == 0) {
    echo json_encode(['data'=>'<h2>未找到符合条件的记录</h2>','sql'=>$query]);
    return;
}
$display_string .= "<tr>";
$display_string .= "<td>用户名</td>";
$display_string .= "<td>年龄</td>";
$display_string .= "<td>性别</td>";
$display_string .= "</tr>";

// Insert a new row in the table for each person returned
while($row = mysqli_fetch_object($qry_result)) {
    $display_string .= "<tr>";
    $display_string .= "<td>$row->username</td>";
    $display_string .= "<td>$row->userage</td>";
    $display_string .= "<td>$row->usersex</td>";
    $display_string .= "</tr>";
}

echo json_encode(['data'=>$display_string,'sql'=>$query]);    //返回json格式数据