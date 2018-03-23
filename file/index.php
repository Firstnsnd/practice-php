<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-22
 * Time: 下午4:58
 */
//======scandir======
//$dir = "/tmp";     //这里输入文件目录
//$files1=scandir($dir);    //读取目录文件
//print_r($files1);

//======文件信息======
$file_path="test.txt";
//该函数返回一个指向文件的指针,如果失败返回false
if($fp=fopen($file_path,"r")){
    $file_info=fstat($fp);//fstat用法可以自己查手册，它是以数组形式返回
    echo "<pre>";
    print_r($file_info);
    echo "</pre>";
    fclose($fp);
}else{
    echo "fail to open";
}

if($fp=fopen($file_path,"r")){
    $file_info=fstat($fp);
    echo "<pre>";
    print_r($file_info);
    echo "</pre>";
    //取出来
    echo "<br/> SiZE is:{$file_info['size']}";
    echo "<br/>Update Time is:{$file_info['mtime']}";
    date("Y-m-d H:i:s");
    echo "<br/>文件上次修改时间 ".date("Y-m-d H:i:s",$file_info['mtime']);
    fclose($fp);
}else{
    echo "fail to open";
}


//======打开读取文件======

if(file_exists($file_path)){
    $fp = fopen($file_path, 'r');
    $con = fread($fp, filesize($file_path));
    echo $con;
    fclose($fp);
}else{
    echo "nothing the file";
}

$fp=fopen($file_path,"a+");
$buffer=1024;
$str="";
//我们设置一次读取1024个字节
//一边读一边判断是否到文件的末尾,用feof函数
//如果文件到了EOF返回真
while(!feof($fp)){
    $str.=fread($fp,$buffer);
    echo $str;
}
fclose($fp);

//======写入文件======
if(file_exists($file_path)){
//如果是追加内容，则使用a+,a+的意思是append(追加)
//如果是全新的写入到文件，则使用w+ ，wirte(写)
    $fp=fopen($file_path,"a+") or die("Unable to open file!");
    $con="hello";
    fwrite($fp, $con);
    echo 'ok';
    $con="\n\r exchange";
    for($i=0;$i<10;$i++){
        fwrite($fp,$con);
    }
//成功echo出ok
}else{
    echo 'File No Exist!';
}
fclose($fp)

//======文件拷贝======
//此处添加代码

//======文件创建与删除======
//此处添加代码