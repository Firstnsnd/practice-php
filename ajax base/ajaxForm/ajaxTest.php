<?php
   error_reporting(0); //不显示警告信息
   $dbhost = "localhost";
   $dbuser = "root";
   $dbpass = "123456";
   $dbname = "ajaxdemo";
   
   $mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
   
   $mysqli->query("SET NAMES 'UTF8'"); //页面输出的汉字不会乱码
   $sql = "select * from ajaxtest where username = '".$_GET["username"]."' ;";
   $res = $mysqli->query($sql,$link);
   $mNums = $res->num_rows;
   if($mNums >= 1){
    echo "<span  style='color:red'>This user name is used</span>";
   } else {
      echo "<span style='color:green'>You can use this user name</span>";
   }
?>