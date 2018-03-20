@extends('admin.layout.master')

@section('header')
@endsection

@section('content')
<body>
	<link href="/admin/static/h-ui.admin\css/H-ui.login.css" rel="stylesheet" type="text/css" />
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"></div>
<div class="loginWraper">
	<div id="loginform" class="loginBox">
		<form class="form form-horizontal" action="" method="post">
			<div class="row cl">
				<label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
				<div class="formControls col-xs-8">
					<input  name="username" type="text" placeholder="账户" class="input-text size-L">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
				<div class="formControls col-xs-8">
					<input  name="password" type="password" placeholder="密码" class="input-text size-L">
				</div>
			</div>
			<div class="row cl">
				<div class="formControls col-xs-8 col-xs-offset-3">
					<input class="input-text size-L" type="text" placeholder="验证码"  onclick="if(this.value=='验证码:'){this.value='';}"   style="width:150px;" name="validate_code">
					<img src="/admin/validate_code/create" class="bk_validate_code">
					<a id="kanbuq" href="javascript:;">看不清，换一张</a>
				</div>
			</div>
			<div class="row cl">
				<div class="formControls col-xs-8 col-xs-offset-3">
					<a class="btn btn-success radius size-L" href="javascript:" onclick="onLoginClick();">&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;</a>
				</div>
			</div>
		</form>
		<div class="bk_toptips" style="display: none;"><span>帐号不能为空</span></div>
	</div>
</div>
<div class="footer">Copyright 你的公司名称 by H-ui.admin.page.v3.0</div>
@endsection

@section('my-js')
<script type="text/javascript">
$('.bk_validate_code').click(function () {
	$(this).attr('src', '/admin/validate_code/create?random=' + Math.random());
});
$('#kanbuq').click(function () {
	$('.bk_validate_code').attr('src', '/admin/validate_code/create?random=' + Math.random());
});
function onLoginClick() {
	  // 帐号
    var username = $('input[name=username]').val();
    if(username.length == 0) {
      $('.bk_toptips').show();
      $('.bk_toptips span').html('帐号不能为空');
      setTimeout(function() {$('.bk_toptips').hide();}, 20000);
      return;
    }
    // 密码
    var password = $('input[name=password]').val();
    if(password.length == 0) {
      $('.bk_toptips').show();
      $('.bk_toptips span').html('密码不能为空!');
      setTimeout(function() {$('.bk_toptips').hide();}, 2000);
      return;
    }
    if(password.length < 6) {
      $('.bk_toptips').show();
      $('.bk_toptips span').html('密码不能少于6位!');
      setTimeout(function() {$('.bk_toptips').hide();}, 2000);
      return;
    }
    // 验证码
    var validate_code = $('input[name=validate_code]').val();
    if(validate_code.length == 0) {
      $('.bk_toptips').show();
      $('.bk_toptips span').html('验证码不能为空!');
      setTimeout(function() {$('.bk_toptips').hide();}, 2000);
      return;
    }
    if(validate_code.length < 4) {
      $('.bk_toptips').show();
      $('.bk_toptips span').html('验证码不能少于4位!');
      setTimeout(function() {$('.bk_toptips').hide();}, 2000);
      return;
    }
	  $.ajax({
	  type: "POST",
	  url: '/admin/login',
	  dataType: 'json',
	  cache: false,
	  data: {username: username, password: password, validate_code: validate_code, _token: "{{csrf_token()}}"},
	  success: function(data) {
	    if(data == null) {
	      $('.bk_toptips').show();
	      $('.bk_toptips span').html('服务端错误');
	      setTimeout(function() {$('.bk_toptips').hide();}, 2000);
	      return;
	    }
	    if(data.status != 0) {
	      $('.bk_toptips').show();
	      $('.bk_toptips span').html(data.message);
	      setTimeout(function() {$('.bk_toptips').hide();}, 2000);
	      return;
	    }

	    $('.bk_toptips').show();
	    $('.bk_toptips span').html('登录成功');
	    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
			@if($return_url != null)
				 location.href = "{{$return_url}}";
			 @else
				 location.href = "/admin/index";
			 @endif


	  },
	  error: function(xhr, status, error) {
	    console.log(xhr);
	    console.log(status);
	    console.log(error);
	  }
	});
}
</script>
@endsection
