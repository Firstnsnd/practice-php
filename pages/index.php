<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-21
 * Time: 上午11:20
 */
require 'Pager.php';
$mysqli = new mysqli('127.0.0.1','root','123456','company') or die('Connection Error');
//$time = date('Y-m-d H:i:s',time());
//$sql1 = "INSERT INTO employee(name,gender,age,avatar,title,depart,update_time,create_time) VALUES('XiaoMing','Male',20,'https://dn-simplecloud.shiyanlou.com/gravatar57FFHPK4T8G8.jpg?imageView2/1/w/30/h/30','Manager','Shiyanlou','$time','$time')";
//for ($i=0; $i < 30; $i++) {
//    $mysqli->query($sql1);
//}


$listRow = 2;	//每页展示数量
$sql = 'SELECT id FROM employee;';
$data = $mysqli->query($sql);
$total = $data->num_rows;		//获取记录总数

$Pager = new Pager($total,$listRow,0,['query'=>['name'=>'admin'],'fragment'=>'top']);	//实例化分页类
$sql = "SELECT * FROM employee LIMIT ".($Pager->getCurrentPage()-1) * $listRow ."," . $listRow;	//获取定量的数据条数
$data = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>分页类</title>
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="height: 800px">
<div class="container" style="text-align: center;display: flex;flex-direction: column;justify-content: center;height: 100%">
    <table class="table table-bordered">
        <caption>员工表</caption>
        <thead>
        <tr>
            <th>Portrait</th>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Title</th>
            <th>Department</th>
            <th>create_time</th>
            <th>update_time</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_object($data)) {
            ?>
            <tr>
                <td><img src= "<?php echo $row->avatar; ?>" alt=""></td>
                <td><?php echo $row->id ?></td>
                <td><?php echo $row->name ?></td>
                <td><?php echo $row->gender ?></td>
                <td><?php echo $row->age ?></td>
                <td><?php echo $row->title ?></td>
                <td><?php echo $row->depart ?></td>
                <td><?php echo $row->create_time ?></td>
                <td><?php echo $row->update_time ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <div class="page">
        <hr>
        <?php echo $Pager->render() ?>
    </div>
</div>
</body>
</html>
