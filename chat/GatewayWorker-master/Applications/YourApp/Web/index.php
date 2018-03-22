<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-22
 * Time: 下午3:08
 */?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="/img/favicon.ico">
    <title>ShiYanLou</title>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body onload="connect()">
<nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="http://www.shiyanlou.com">ShiYanLou Chat</a>
        </div>
    </div><!-- /.container -->
</nav><!-- /.navbar -->

<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Room:<span id="roomid"><?php echo isset($_GET['room_id']) ? $_GET['room_id'] : 1 ?></span> || User:<span id="user"></span> <span id="currendtime" style="float: right"></span>
                </div>
                <div class="panel-body dialog">
                    <div style="height: 500px;overflow-x:hidden" id="dialog">

                    </div>
                    <hr>
                    <textarea class="form-control" rows="5" id="content" placeholder="chat with your friends!"></textarea>
                    <br>
                    <button type="button" class="btn btn-warning clear" onclick="clear_dialog()">clear</button>

                    <!-- Split button -->
                    <div class="btn-group" style="float:right">
                        <button type="button" class="btn btn-info" onclick="onSubmit()">Commit</button>
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <!--  <span class="sr-only">Commit</span> -->
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li class="mth" value="e"><span >✔ &nbsp;</span>Enter to send</li>
                            <li class="mth" value="ec"><span hidden="">✔ &nbsp;</span>Enter+Ctrl to send</li>
                        </ul>
                    </div>

                    <div class="col-md-2" style="float: right">
                        <select class="form-control" id="client_list_select">
                        </select>
                    </div>

                </div>
                <div class="panel-footer">
                    <p class="cp" style="text-align: center">PHP多进程+Websocket(HTML5/Flash)+PHP Socket实时推送技术&nbsp;&nbsp;&nbsp;&nbsp;Powered by <a href="http://www.workerman.net/workerman-chat" target="_blank">workerman-chat</a>
                    </p>
                </div>
            </div>
            <a href="/?room_id=1" title="" id="room1"><button type="button" class="btn btn-info roomid">Room1</button></a>
            <a href="/?room_id=2" title="" id="room2"><button type="button" class="btn btn-info roomid">Room2</button></a>
            <a href="/?room_id=3" title="" id="room3"><button type="button" class="btn btn-info roomid">Room3</button></a>
            <a href="/?room_id=4" title="" id="room4"><button type="button" class="btn btn-info roomid">Room4</button></a>
        </div>
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            当前房间在线用户：
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body" style="padding: 0">
                        <div class="list-group">
                            <div id="sidebar_client_list">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.sidebar-offcanvas-->
    </div>
</div>
<script type="text/javascript">
    var ws, name, client_list={};
    function connect() {
        // 连接服务端
        WEB_SOCKET_DEBUG = true;
        //  创建websocket
        ws = new WebSocket("ws://"+document.domain+":8282");
        // 当socket连接打开时，输入用户名
        ws.onopen = onopen;
        ws.onmessage = onmessage;
        ws.onclose = function() {
            console.log("连接关闭，定时重连");
            setInterval(connect(),10);
        };
        ws.onerror = function() {
            console.log("出现错误");
        };

    }
function show_prompt() {
  name = prompt('请输入你的用户名:','');
  if (!name || name == '') {
    name = '游客';
  }
  $('#user').text(name);
}
    // 建立连接
    function onopen() {
        if (!name) {
            show_prompt();    //展示输入框
        }
        $('#user').text(name);
        var login_data = '{"type":"login","client_name":"'+name.replace(/"/g, '\\"')+'","room_id":"<?php echo isset($_GET['room_id']) ? $_GET['room_id'] : 1?>"}';
        ws.send(login_data);
        console.log('handshake success,send login_data:'+login_data);
    }

    // 服务端发来消息时
    function onmessage(e)
    {
        console.log(e.data);
        var data = eval("("+e.data+")");
        switch(data['type']){
            // 服务端ping客户端
            case 'ping':
                ws.send('{"type":"pong"}');
                break;;
            // 登录 更新用户列表
            case 'login':
                //{"type":"login","client_id":xxx,"client_name":"xxx","client_list":"[...]","time":"xxx"}
                say(data['client_id'], data['client_name'],  data['client_name']+' 加入了聊天室', data['time'],'login');
                if(data['client_list'])
                {
                    client_list = data['client_list'];
                }
                else
                {
                    client_list[data['client_id']] = data['client_name'];
                }
                flush_client_list();
                console.log(data['client_name']+"登录成功");
                break;
            // 发言
            case 'say':
                //{"type":"say","from_client_id":xxx,"to_client_id":"all/client_id","content":"xxx","time":"xxx"}
                say(data['from_client_id'], data['from_client_name'], data['content'], data['time'],'say');
                break;
            // 用户退出 更新用户列表
            case 'logout':
                //{"type":"logout","client_id":xxx,"time":"xxx"}
                say(data['from_client_id'], data['from_client_name'], data['from_client_name']+' 退出了', data['time'],'logout');
                delete client_list[data['from_client_id']];
                flush_client_list();
        }
    }

    function say(from_client_id,from_client_name,content,time,type) {
        if (type == 'say') {        //用户发言
            if (from_client_id == 'mine') {        //自己的发言
                $('#dialog').append(' <div class="media"><div class="media-body"><h4 class="media-heading" style="text-align: right"><small>'+time+'</small> &nbsp;&nbsp;&nbsp; '+from_client_name+' </h4><ul class="list-group"><li class="list-group-item list-group-item-info" style="text-align: right">'+content+'</li></ul></div><a class="media-right" href="#"><img src="img/headimg.png" alt="..."></a></div>');
                $('#dialog').scrollTop($('#dialog')[0].scrollHeight);
            } else {        //他人的发言
                $('#dialog').append('<div class="media"><a class="media-left" href="#"><img src="img/headimg.png" alt="..."></a><div class="media-body"><h4 class="media-heading">'+from_client_name+'  &nbsp;&nbsp;&nbsp; <small>'+time+'</small></h4><ul class="list-group"><li class="list-group-item list-group-item-info">'+content+'</li></ul></div></div>');
                $('#dialog').scrollTop($('#dialog')[0].scrollHeight);
                notify();
            }
        } else if(type == 'logout') {        //用户登出
            $('#dialog').append('<p class="bg-danger" style="text-align: center">'+from_client_name+' logout</p>')
            $('#dialog').scrollTop($('#dialog')[0].scrollHeight);
        } else if (type == 'login') {        //用户登录
            $('#dialog').append('<p class="bg-success" style="text-align: center">'+from_client_name+' login</p>')
            $('#dialog').scrollTop($('#dialog')[0].scrollHeight);
        }
    }

    function flush_client_list() {
        var sidebar_client_list = $('#sidebar_client_list');
        var client_list_select = $('#client_list_select');
        sidebar_client_list.empty();
        client_list_select.empty();
        client_list_select.append('<option value = "all">All</option>');        //添加默认选项
        for(var p in client_list){
            if (client_list[p] !=  $('#user').text()) {        //筛选自己（比对用户名）
                sidebar_client_list.append('<li class="list-group-item chatable" id="'+p+'" onclick="javascript:bindclick(this.id)">'+client_list[p]+'</li>');
                client_list_select.append('<option value = "'+p+'">'+client_list[p]+'</option>');
            } else {
                sidebar_client_list.append('<li class="list-group-item disabled" id="'+p+'">'+client_list[p]+'*</li>');
            }
        }
    }

    function onSubmit() {
        var to_client_name = $('#client_list_select option:selected').text();
        var to_client_id = $('#client_list_select option:selected').attr('value');
        var input = $('textarea').val();
        var str = '{"type":"say","to_client_id":"'+to_client_id+'","to_client_name":"'+to_client_name+'","content":"'+input.replace(/"/g, '\\"').replace(/\n/g,'\\n').replace(/\r/g, '\\r')+'"}';
        ws.send('{"type":"say","to_client_id":"'+to_client_id+'","to_client_name":"'+to_client_name+'","content":"'+input.replace(/"/g, '\\"').replace(/\n/g,'\\n').replace(/\r/g, '\\r')+'"}');
        $('textarea').val('');
        $('textarea').focus();
    }

    function clear_dialog() {
        $('#dialog').empty();
        $('textarea').focus();
    }
    function bindclick(to_id) {
        $("#client_list_select").val(to_id);
        $('body').animate({scrollTop:document.body.scrollHeight}, 0);
        $('textarea').focus();
    }
    function notify() {
        var title = $('title').text();
        var step =1;
        var timer = setInterval(function(){
            step++;
            if (step==3) {step=1};
            if (step==1) {$('title').text("【newMsg】"+title)};
            if (step==2) {$('title').text("【新消息】"+title)};
        },500);        //500毫秒执行一次，一秒闪烁两次

        //用户查看当前页面，停止闪烁，标题还原
        $(window).focus(function(){
            clearInterval(timer);
            $('title').text(title);
        });

        //若用户一直未查看，则10s之后关闭提醒，标题还原
        setTimeout(function () {
            clearInterval(timer);
            $('title').text(title);
        },10000);
    }
    function getCurDate() {
        var d = new Date();
        var week;
        switch (d.getDay()){
            case 1: week="星期一"; break;
            case 2: week="星期二"; break;
            case 3: week="星期三"; break;
            case 4: week="星期四"; break;
            case 5: week="星期五"; break;
            case 6: week="星期六"; break;
            default: week="星期天";
        }
        var years = d.getFullYear();
        var month = add_zero(d.getMonth()+1);
        var days = add_zero(d.getDate());
        var hours = add_zero(d.getHours());
        var minutes = add_zero(d.getMinutes());
        var seconds=add_zero(d.getSeconds());
        var ndate = years+"年"+month+"月"+days+"日 "+hours+":"+minutes+":"+seconds+" "+week;
        $('#currendtime').text(ndate);
    }
    function add_zero(temp)
    {
        if(temp<10) return "0"+temp;
        else return temp;
    }
    setInterval(getCurDate,1000);
    var send_method = 'e';        //默认发送方式 'Enter' 用 'e' 表示。 'Ctrl+Enter' 用 'ec 表示
    $('.dropdown-menu li').each(function(){
        $(this).click(function () {        //点击选择方式，切换✔的显示
            $(this).children().removeAttr('hidden');
            $(this).siblings().children().attr('hidden', '');
            if ($(this).attr('value') == 'e') {        //修改 send_method 的值
                send_method = 'e';
            } else {
                send_method = 'ec';
            }
        })
    })

    $('textarea').keydown(function(e) {        //监听 textarea 标签的键盘输入事件
        if (send_method == 'e') {    //若发送方式为 'Enter，
            if ((e.ctrlKey == false) && e.keyCode == 13) {        //按下 'Enter' 没有按下 'Ctrl' ,发送消息
                onSubmit(); //发送消息
                e.preventDefault();        //这一句很关键，阻止输入事件的继续进行。否则 textarea 内会有一个换行
            } else if (e.ctrlKey && e.keyCode == 13) {            //发送方式为 'Enter，按下 'Ctrl+Enter' 为换行
                $('textarea').val($('textarea').val()+'\r\n');
            }
        } else {        //发送消息的快捷键为 'Ctrl+Enter'
            if (e.ctrlKey && e.keyCode == 13) {        //同时按下这两个键，发送消息
                onSubmit();
            }
        }
    });
</script>
</body>
</html>
