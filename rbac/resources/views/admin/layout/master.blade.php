<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<link rel="Bookmark" href="favicon.ico" >
	<link rel="Shortcut Icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
	<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
	<link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
	<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
	<link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
	<link rel="stylesheet"  href="/admin/book.css">
	<title>RBAC后台管理</title>
	</head>

	<body>
		@section('header')
		<header class="navbar-wrapper">
			<div class="navbar navbar-fixed-top">
				<div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/admin/index">RBAC</a> 
					<span class="logo navbar-slogan f-l mr-10 hidden-xs">后台</span>
					<a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
					<nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
						<ul class="cl">
							<li>@if(Session::get('rolename') !=null ){{ Session::get('rolename') }}@endif:</li>
							<li class="dropDown dropDown_hover">
								<a href="#" class="dropDown_A">@if(Session::get('admin') !=null ){{ Session::get('admin.data') }}@endif <i class="Hui-iconfont">&#xe6d5;</i></a>
								<ul class="dropDown-menu menu radius box-shadow">
									<li><a href="/admin/logout">退出</a></li>
								</ul>
							</li>
							<li id="Hui-msg"> <a href="#" title="消息"><span class="badge badge-danger"></span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>
						</ul>
					</nav>
				</div>
			</div>
		</header>
			<aside class="Hui-aside">

					<div class="menu_dropdown bk_2">
							<dl>
									<dt><i class="Hui-iconfont">&#xe681;</i>常用操作<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
										<ul>
											<li><a href="/admin/product/index" title="管理员列表">商品管理</a></li>
											<li><a href="/admin/order/index" title="角色列表">订单管理</a></li>
										</ul>
						</dl>
							<hr>
								<dl>
										<dt><i class="Hui-iconfont">&#xe681;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
											<ul>
												<li><a href="/admin/manager/index" title="管理员列表">管理员列表</a></li>
												<li><a href="/admin/role/index" title="角色列表">角色列表</a></li>
												<li><a href="/admin/permission/index" title="权限列表">权限列表</a></li>
											</ul>
							</dl>

			</div>
			</aside>
			<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
			@show

			@yield('content')

			<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
			<script type="text/javascript" src="/admin/lib/jquery.form.js"></script>
			<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
			<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.js"></script>
			<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.page.js"></script>
			<script type="text/javascript" src="/admin/static/h-ui.admin/js/uploadFile.js"></script>
			<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/ueditor.config.js"></script>
			<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
			<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>

			@yield('my-js')
		</body>
</html>
