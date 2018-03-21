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
									<img src="validateCode.php" id="oimg">
					</div><br>
				 </form>
				</div>
				<div style="margin-top:40px;">
					 <input class="form-control btn btn-info" type="button" onclick="onLoginClick()" value="登录"/>
				</div>
		 </div>
	</div>
</body>
<script type="text/javascript">
    //点击验证马图片使之产生新的随机验证码
    $('#oimg').click(function (){
        $(this).attr('src','validateCode.php?random='+Math.random());
    });
    function onLoginClick() {
        // 帐号、验证码
        var username = $('input[name=username]').val();
        var password = $('input[name=password]').val();
        var validateCode = $('input[name=validateCode]').val();
        $.ajax({
            type: "POST",
            url: 'loginController.php',
            dataType: 'json',
            cache: false,
            data: {username: username, password: password, validateCode: validateCode},
            success: function (data) {
                if (data == '0') {
                    alert('验证码错误！');
                } else if (data == '00') {
                    alert('账号或密码错误！');
                } else {
                    location.href = "https://www.shiyanlou.com/";
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
    }
</script>
</html>
