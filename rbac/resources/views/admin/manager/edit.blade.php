@extends('admin.layout.master')

@section('header')
@endsection

@section('content')
<article class="cl pd-20">
	<form action="" method="post" class="form form-horizontal" id="form-manager-create">
	  {{ csrf_field() }}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<select class="select" name="roleid" size="1">
					<!-- <option value="">请选择</option> -->
					@foreach ($roles as $role)
						@if($role['id'] != 1)
						@if($role['id'] == $manager_id['roleid'])
							{{$selected="selected='selected'"}}
						@else
							{{$selected=""}}
						@endif
					<option value="{{$role['id']}}" {{$selected}}>{{$role['rolename']}}</option>
						@endif
					@endforeach
				</select>
			</div>
			<div class="col-4"> </div>
		</div>
	  <div class="row cl">
	    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
	    <div class="formControls col-xs-8 col-sm-9">
	      <input type="text" class="input-text" value="{{$manager_id['username']}}" placeholder="" id="username"  name="username" >
	    </div>
	    <div class="col-4"> </div>
	  </div>
	  <div class="row cl">
	    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
	    <div class="formControls col-xs-8 col-sm-9">
	      <input type="password" class="input-text" value="" placeholder="" id="oldpassword" name="oldpassword"  >
	    </div>
	    <div class="col-4"> </div>
	  </div>
	  <div class="row cl">
	    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>原密码：</label>
	    <div class="formControls col-xs-8 col-sm-9">
	      <input type="password" class="input-text" value="" placeholder="" id="password" name="password"  >
	    </div>
	    <div class="col-4"> </div>
	  </div>
		<div class="row cl">
	    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
	    <div class="formControls col-xs-8 col-sm-9">
	      <input type="password" class="input-text" value="" placeholder="" id="repassword" name="repassword"  >
	    </div>
	    <div class="col-4"> </div>
	  </div>

	  <div class="row cl">
	    <div class="col-9 col-offset-3">
	      <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
	    </div>
	  </div>
	</form>
</article>
@endsection

@section('my-js')
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">

$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});

	$("#form-manager-create").validate({
		rules:{
			username:{
				required:true,
				minlength:6,
				maxlength:32
			},
			oldpassword:{
				required:true,
				minlength:6,
				maxlength:32
			},
			password:{
				required:true,
				minlength:6,
				maxlength:32
			},
			repassword:{
				required:true,
				minlength:6,
				maxlength:32,
				equalTo:"#password"
			}
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
		  $('#form-manager-create').ajaxSubmit({
          type: 'post', // 提交方式 get/post
          url: '/admin/manager/edit', // 需要提交的 url
          dataType: 'json',
          data: {
						id:{{$manager_id['id']}},
            username: $('input[name=username]').val(),
            oldpassword: $('input[name=oldpassword]').val(),
            password: $('input[name=password]').val(),
            repassword: $('input[name=repassword]').val(),
            roleid: $('input[name=roleid]').val(),
            _token: "{{csrf_token()}}"
          },
          success: function(data) {
            if(data == null) {
              layer.msg('服务端错误', {icon:2, time:2000});
              return;
            }
            if(data.status != 0) {
              layer.msg(data.message, {icon:2, time:2000});
							location.replace(location.href);
              return;
            }

            layer.msg(data.message, {icon:1, time:2000});
  					parent.location.reload();
          },
          error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
            layer.msg('ajax error', {icon:2, time:2000});
          },
          beforeSend: function(xhr){
            layer.load(0, {shade: false});
          },
        });

        return false;
		}
	});
});
</script>
@endsection
