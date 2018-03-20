 <?php
require 'config.php';
require 'mysql.class.php';
header("Content-Type: text/html;charset=utf-8");
DB::connect();
$nickname = DB::$con->real_escape_string($_POST['nickname']);
$content = DB::$con->real_escape_string($_POST['content']);
if (empty($nickname) || empty($content)) {
	exit('{"error":"1","msg":"Nickname or content cannot empty"}');
}
if (mb_strlen($nickname) > 10 || mb_strlen($content) > 50) {
	exit('{"error":"1","msg":"Length incorrect"}');
}
if (!empty($_POST['email'])) {
	$email = DB::$con->real_escape_string($_POST['email']);
	$email_reg = '/\w+([-+.]\w+)*@\w+([-.]\w+)*.\w+([-.]\w+)*/'; //邮箱正则
	if(!preg_match($email_reg, $email)) {
		exit('{"error":1, "msg":"Email address not legal"}');
	}
} else {
	$email = '';
}
$create_time = date('Y-m-d H:i:s',time());
$sql_insert = 'insert into ' . GB_TABLE_NAME . '(nickname, content, createtime, email) values( ' . "'{$nickname}', '{$content}', '{$create_time}' , '{$email}')";
$insert_status = mysqli_query(DB::$con,$sql_insert);
DB::close();

if($insert_status) {
	 echo json_encode(['error'=>'0','msg'=>'Success message']);
} else{
	echo json_encode(['error'=>'1','msg'=>'Messages failed']);
}

