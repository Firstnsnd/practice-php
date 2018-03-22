<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-22
 * Time: 下午2:34
 */
error_reporting(0); //不显示警告信息
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ajaxdemo";
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
$mysqli->query("SET NAMES 'UTF8'"); //页面输出的汉字不会乱码
$sql = "select * from courses where coursesname like '%".$_GET["keywords"]."%'";
$res = $mysqli->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ajax实例</title>
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="height: 800px">
<div class="container">
    <div class="panel panel-default" style="margin-top: 100px;text-align: center;">
        <div class="panel-heading">AjaxSearch Test</div>
        <div class="panel-body">
            <div class="row">
                <?php
                while ($row = mysqli_fetch_array($res)) {
                    echo '<div class="col-md-8 col-md-offset-2"><h2>'.$row["coursesname"].'</h2><p>
          UpdateTime: <span>'.date("Y-m-d",strtotime($row["coursestime"])).'</span> 
          Author: <span>'.$row["coursesuser"].'</span>
        </p>'.$row["coursescontent"].'<p></p><hr>
        </div>';
                }
                ?>
            </div><!-- /.row -->
        </div>
    </div>
</div>
</body>
</html>
