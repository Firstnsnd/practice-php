<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-22
 * Time: 上午10:30
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
      <div class="panel-heading">Ajax实例</div>
      <div class="panel-body">

        <form class="navbar-form navbar-center    " role="search" name="myForm">
          <div class="form-group">
            <label>年龄：<input type="number" class="form-control" placeholder="Age" name="userage" id = 'userage' ></label>
          </div>
          <select class="form-control" id = 'usersex' name="usersex">
            <option value = "男">男</option>
            <option value = "女">女</option>
          </select>
          <button type="button" class="btn btn-default" onclick = 'ajaxFunction()'>提交</button>
        </form>

          <table class="table table-condensed table-bordered" id="ajaxDiv">
        </table>
        <p>SQL语句： <pre id="sql"></pre></p>
      </div>
    </div>
</div>
<script src="jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

<script type = "text/javascript">
            function ajaxFunction(){
                var xmlHttp;
                try {
                    xmlHttp = new XMLHttpRequest();
                }catch (e) {
                    try {
                        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                    }catch (e) {
                        try{
                            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }catch (e){
                            alert("您的浏览器不支持!");
                            return false;
                        }
                    }
                }
                xmlHttp.onreadystatechange = function(){
                    if(xmlHttp.readyState == 4){
                        var ajaxData = document.getElementById('ajaxDiv');
                        var sqlData = document.getElementById('sql');
                        var jsonData = JSON.parse(xmlHttp.responseText);    //解析json数据
                        ajaxData.innerHTML = jsonData.data;
                        sqlData.innerHTML = jsonData.sql;
                    }
                }
               var userage = document.getElementById('userage').value;
               var usersex = document.getElementById('usersex').value;
               var url = "?userage=" + userage ;
               url +=  "&usersex=" + usersex;
               xmlHttp.open("GET", "ajaxTest.php" + url, true);
               xmlHttp.send();
            }
</script>
</body>
</html>