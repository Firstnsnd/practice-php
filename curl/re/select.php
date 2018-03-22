<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8"/>
</head>
</html>
<?php
header('content-type:text/html; charset=utf8'); 
//定义数据库连接的参数
define("DB_HOST","localhost");  
define("DB_USER","root");  
define("DB_PWD","123456");
define("DB_NAME","curl");  
define("DB_CHARSET","utf8");  
//数据库连接方法
function connect(){  
    $link = new mysqli(DB_HOST,DB_USER,DB_PWD,DB_NAME);
    $sql = 'set names '.DB_CHARSET;  
    mysqli_query($link,$sql) or die ("设置字符集失败");  
    return $link;
}
//数据库连接
$mysqli = connect(); 
$sql = "select * from curl order by id desc";  
if($result = $mysqli->query($sql)){  
    $values = mysqli_fetch_assoc($result);   
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p><img src=".$row["imgurl"]." width=400 height=200><br>";
        echo $row["title"]."</p>";
    }
}
else{  
    echo '提取失败';  
}  