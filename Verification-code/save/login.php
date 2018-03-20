<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录页面</title>
<link rel="stylesheet" href="dome.css">
<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="box">
		 <div class="cnt">
				<p id="huanying"><span id="cnt_one">欢迎登录</span></p>
				<hr />
				<div>
					 <form class="bs-example bs-example-form" role="form">
					<div class="input-group">
						<span class="input-group-addon"><img src="user.png"></span>
						<input type="text" name="username" class="form-control" placeholder="请输入您的账号">
					</div><br>
					<div class="input-group">
						<span class="input-group-addon"><img src="suo.png"></span>
						<input type="password" name="password" class="form-control" placeholder="请输入您的密码">
					</div><br>
					<div class="input-group" style="position:absolute;">

						<input type="text" name="validateCode" class="form-control" placeholder="请输入验证码" style="position:relative;width:191px;height:33px;">
									<img src="yanzhengma.png" id="oimg">
					</div><br>
				 </form>
				</div>
				<div style="margin-top:40px;">
					 <input class="form-control btn btn-info" type="button" value="登录"/>
				</div>
		 </div>
	</div>
</body>
</html>
