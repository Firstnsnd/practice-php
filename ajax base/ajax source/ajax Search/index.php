<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-22
 * Time: 下午2:31
 */
?>
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
      <div class="panel-heading">AjaxSearch Test</div>
      <div class="panel-body">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="input-group">
            <form action="searchResult.php" method="get" id="form">
                <input type="text" class="form-control" name="keywords" id="keywords" onkeyup="showHint(this.value)">
            </form>
            <span class="input-group-btn">
              <button class="btn btn-default" type="button" onclick="formSubmit()">Go!</button>
            </span>
          </div><!-- /input-group -->
          <div id="showsug" style="text-align: left;width: 91%;display: none;">
          </div>
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->
      </div>
    </div>
</div>


<script>
         function showHint(str) {        //重要部分
             if (str.length == 0) {
                 document.getElementById("showsug").innerHTML = "";
                 return;
             }else {
                 var xmlhttp = new XMLHttpRequest();

                 xmlhttp.onreadystatechange = function() {
                     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                         document.getElementById("showsug").style.display="block";
                         document.getElementById("showsug").innerHTML = xmlhttp.responseText;
                     }
                 }

               xmlhttp.open("GET", "ajaxTest.php?wd=" + str, true);
               xmlhttp.send();
            }
         }
         function formSubmit () { //提交表单
             document.getElementById("form").submit();
         }
</script>
</body>
</html>