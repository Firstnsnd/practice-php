@extends('admin.layout.master')

@section('header')
@endsection

@section('content')
<article class="cl pd-20">
	<form action="" method="post" class="form form-horizontal" id="form-permission-create">
		{{ csrf_field() }}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>上级分类：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<select class="select" name="pid" size="1">
					<option value="0">顶级分类</option>
					@foreach($permissions as $permission)
							<option value="{{$permission['id']}}">{{$permission['pername']}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="pername" name="pername">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>模块名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="name" name="mname">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>控制器名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="name" name="cname">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>操作方法名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="aname" name="aname">
			</div>
		</div>

		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>

@endsection


@section('my-js')
<!--请在下方写此页面业务相关的脚本-->
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

	$("#form-permission-create").validate({
		rules:{
			pername:{
				required:true,
				minlength:4,
				maxlength:16
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			 $('#form-permission-create').ajaxSubmit({
            type: 'post', // 提交方式 get/post
            url: '/admin/permission/create', // 需要提交的 url
            dataType: 'json',
            data: {
							pid: $('select[name=pid] option:selected').val(),
              pername: $('input[name=pername]').val(),
              mname: $('input[name=mname]').val(),
              cname: $('input[name=cname]').val(),
              aname: $('select[name=aname] option:selected').val(),
              _token: "{{csrf_token()}}"
            },
            success: function(data) {
							// alert(data);
              if(data == null) {
                layer.msg('服务端错误', {icon:2, time:3000});
                return;
              }
              if(data.status != 0) {
                layer.msg(data.message, {icon:2, time:3000});
                return;
              }

              layer.msg(data.message, {icon:1, time:3000});
    					parent.location.reload();
            },
            error: function(xhr, status, error) {
              console.log(xhr);
              console.log(status);
              console.log(error);
              layer.msg('ajax error', {icon:2, time:3000});
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
<!--/请在上方写此页面业务相关的脚本-->
@endsection
