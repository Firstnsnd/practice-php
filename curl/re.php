<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-21
 * Time: 下午4:03
 */
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
//匹配样式是course-title的span把标题赋值给变量
preg_match_all("/<div class=\"course-name\">(.*?)<\/div>/",$resault, $title);
//打印出数组$title
print_r($title);
foreach($title[0] as $key => $value){
    //此处$value是数组，同时记录找到带匹配字符的整句和单独匹配的字符
    echo  $value;
    echo "<br>";
}

preg_match_all("/https\:\/\/dn-simplecloud.shiyanlou.com\/(.*?)g/",$resault, $img, PREG_SET_ORDER);
foreach($img as $key => $value){
    echo $value[0];
    echo "<br>";
}

//获取标题数组
function curlTitle($arr=array()){
    //使用foreach循环输出title，在上面例子里我们可以看到title在数组中的位置。
    foreach($arr[0] as $key => $value){
        @$resault .= $value."|";
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


//输出结果
print_r(curlTitle($title));
echo "<br>";
echo "<br>";
echo "<br>";
print_r( curlImg($img));

$Arrend =array();
foreach (curlTitle($title) as $k => $r) {
    $Arrend[] = array(curlTitle($title)[$k],curlImg($img)[$k]);
}

//打印重新组合的结果
echo '<pre>';
print_r($Arrend);
echo '</pre>';
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