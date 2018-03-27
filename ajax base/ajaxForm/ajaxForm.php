    <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ajax实例</title>
	<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="height: 800px">
<div class="container">
	<div class="panel panel-default" style="margin-top: 100px;text-align: center;">
	  <div class="panel-heading">AjaxForm Test</div>
	  <div class="panel-body">

		<form class="navbar-form navbar-center	"  id="contact"  method="post">
		  <div class="form-group">
		    <label>UserName：<input type="text" class="form-control" placeholder="username" name="username" id='username' onblur="showHint()"></label>
		  </div>
        <span id="showsug"></span>
		</form>
	  </div>
	</div>
</div>


<script>
         function showHint() {
          var str=document.getElementById("username").value;
            if (str.length == 0) {
               document.getElementById("showsug").innerHTML = "用户名不能为空";
               return;
            }else {
               var xmlhttp = new XMLHttpRequest();
               xmlhttp.onreadystatechange = function() {
                  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                     document.getElementById("showsug").innerHTML = xmlhttp.responseText;
                  }
               }

               xmlhttp.open("GET", "/ajaxForm/ajaxTest.php?username=" + str, true);
               xmlhttp.send();
            }
         }
</script>
</body>
</html>
