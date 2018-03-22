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
//1.初始化，创建一个新cURL资源
$curl=curl_init();
//2.设置URL和相应的选项,我们采集`https://www.shiyanlou.com/`页面
curl_setopt($curl, CURLOPT_URL, "https://www.shiyanlou.com/courses/");
//如果你想把一个头包含在输出中，设置这个选项为一个非零值
curl_setopt($curl, CURLOPT_HEADER, 1);
// 执行之后不直接打印出来
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// 跳过证书检测 0 或 false
curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
//3.执行并获取结果
$resault=curl_exec($curl);
//释放CURL

curl_close($curl);

//匹配标题和图片
preg_match_all("/<div class=\"course-name\"(.*?)>(.*?)<\/div>/",$resault, $out, PREG_SET_ORDER);
preg_match_all("/https\:\/\/dn-simplecloud.shiyanlou.com\/(.*?)g/",$resault, $img, PREG_SET_ORDER);

//获取标题和图片数组的方法
//获取标题数组
function curlTitle($arr=array()){
    //使用foreach循环输出title，在上面例子里我们可以看到title在数组中的位置。
    foreach($arr as $key => $value){ 
        @$resault .= $value[2]."|";
    }
    //array_filter去掉数组中的空值，explode把字符串以数组形式重组
    return array_filter(explode("|",$resault));
}
 
//获取图片数组
function curlImg($arr=array()){
    foreach($arr as $key => $value){ 
        @$resault .= $value[0]."|";
    }
    return array_filter(explode("|",$resault));
}
//把两个数组合成一个数组
foreach (curlTitle($out) as $k => $r) {
     $Arrend[] = array(curlTitle($out)[$k],curlImg($img)[$k]);
}
//数据库连接方法
function connect(){  
    $link = new mysqli(DB_HOST,DB_USER,DB_PWD,DB_NAME);
    $sql = 'set names '.DB_CHARSET;  
    mysqli_query($link,$sql) or die ("设置字符集失败");  
    return $link;
}  
//数据库连接
$mysqli = connect();
//把数组数据循环插入数据库，未做重命名判断
foreach($Arrend as $key => $value){ 
    $sql = "insert curl(title,imgurl) values('".$value[0]."','".$value[1]."')";
    $result = $mysqli->query($sql);
    if(!$result){
        echo "添加失败";
    }
}
?>