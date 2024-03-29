@extends('admin.layout.master')

@section('header')
@endsection

@section('content')
<article class="cl pd-20">
	<form action="" method="post" class="form form-horizontal" id="form-role-edit">
	  {{ csrf_field() }}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
					 <input type="text" class="input-text" value="{{$role_id['rolename']}}" placeholder="" name="rolename" >
			</div>
			<div class="col-4"> </div>
		</div>
	  <div class="row cl">
	    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
	    <div class="formControls col-xs-8 col-sm-9">
							@foreach($permissions as $permis)
							<ul>
								<li id="" style="margin-top:10px;">
									@if ($permis['pid'] != 0)
									<input
									@if (strpos("$role_id->per_list", "$permis->id") !== false)
										{{$check="checked='checked'"}}
									@else
										{{$check=""}}
									@endif  type="checkbox" name="per_list[]" value="{{ $permis['id']}}">{{$permis['pername']}}{{$permis->pid == 0 ? '：' : ''}}
									@else
									{{$permis['pername']}}:
									@endif
								</li>
							</ul>
							@endforeach
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

	$("#form-role-edit").validate({
		rules:{
			rolename:{
				required:true,
				minlength:4,
				maxlength:32
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
		  $('#form-role-edit').ajaxSubmit({
          type: 'post', // 提交方式 get/post
          url: "/admin/role/edit", // 需要提交的 url
          dataType: 'json',
          data: {
            id: {{$role_id['id']}},
            rolename: $('input[name=rolename]').val(),
            _token: "{{csrf_token()}}"
          },
          success: function(data) {
            if(data == null) {
              layer.msg('服务端错误', {icon:2, time:2000});
              return;
            }
            if(data.status != 0) {
              layer.msg(data.message, {icon:2, time:2000});
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
