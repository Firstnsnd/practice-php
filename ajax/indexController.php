<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-20
 * Time: 下午3:27
 */
$action = $_REQUEST['action'];

// 通过传递过来的action参数来对应相对应的操作
switch($action) {
    case 'show':
        show();
        break;
    case 'add':
        add();
        break;
    case 'edit':
        edit();
        break;
    case 'del':
        del();
        break;
}

/**
 * show 数据展示
 */
function show(){
    $sql = "SELECT * FROM `student`";
    $res = mysqli($sql);
    while($row = $res->fetch_assoc()){
        $data[] = $row;
    }

    echo json_encode($data);
}

/**
 * add 数据添加
 */
function add() {
    $name = $_POST['post_data']['col_0'];
    $age = $_POST['post_data']['col_1'];
    $sql = "INSERT INTO `student` (name, age) VALUES ('{$name}', '{$age}')";

    if($res=mysqli($sql)){
        // 获取最后一次插入数据的id
        $sql2 = 'SELECT `id` FROM `student` ORDER BY `id` DESC  LIMIT 1';
        $res2 = mysqli($sql2);
        $id = $res2->fetch_assoc();
        echo $id['id'];
    }else{

        echo 0;
    }
}

/**
 * edit 数据修改
 */
function edit(){
    $id = $_POST['post_data']['id'];
    $name = $_POST['post_data']['col_0'];
    $age = $_POST['post_data']['col_1'];

    $sql = "UPDATE `student` SET name='{$name}',age={$age} WHERE id={$id}";
    if(mysqli($sql)){
        echo 1;
    }else{
        echo 0;
    }
}

/**
 * del 数据删除
 */
function del(){
    $id = $_POST['id'];
    $sql="DELETE FROM `student` WHERE id={$id}";
    if(mysqli($sql)){
        echo 1;
    }else{
        echo 0;
    }

}

/**
 * mysqli      mysqli数据库操作
 * @param   $sql        sql语句
 * @return  mixed
 */
function mysqli($sql){
    $mysqli = new mysqli("localhost", "root", "123456", "tables");
    $mysqli->query("set names utf8");
    $query = $mysqli->query($sql);
    $mysqli->close();
    return $query;
}

