<?php
   //接受提交文件的用户
    $username=$_POST['username'];
    $fileintro=$_POST['fileintro'];
    echo $username.$fileintro;
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    //判断是否上传成功
    if(is_uploaded_file($_FILES['myfile']['tmp_name'])){
        $upload_file=$_FILES['myfile']['tmp_name'];
      	 $destDir = $_SERVER['DOCUMENT_ROOT']."/src/";	//目标目录
        $move_to_file=$destDir.$_FILES['myfile']['name'];
        echo $upload_file."||".$move_to_file."<br>";
        //这里是先把路径打出来，看看我们写对没有，再调用move_uploaded_file
      	 //判断上传目录是否存在
     	 /* if (!is_dir($destDir)) {	//不存在，创建目录，开放所有权限
           mkdir($destDir,0777,ture)
        }
        */
        /*if (move_uploaded_file($upload_file,$move_to_file)) {
          echo "Upload Success!";
        } else {
          echo "Error!";
        }*/
    }
?>