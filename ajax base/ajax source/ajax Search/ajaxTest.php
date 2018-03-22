<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-22
 * Time: 下午2:32
 */
error_reporting(0); //不显示警告信息
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "123456";
$dbname = "ajaxdemo";
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
$mysqli->query("SET NAMES 'UTF8'"); //页面输出的汉字不会乱码
$sql = "select * from courses where coursesname like '%".$_GET["wd"]."%' order by  coursesid;";
$res = $mysqli->query($sql);
$mNums = $res->num_rows;
$dataString = '<ul class="list-group">';
if($mNums < 1){
    echo "The database does not have this content";
    exit();
} else {
    while ($row = mysqli_fetch_array($res)) {
        $dataString.="<a href='searchResult.php?keywords=".$row['coursesname']."' class='list-group-item'>".$row['coursesname']."</a>";
    }
}
echo $dataString.'</ul>';
?>
