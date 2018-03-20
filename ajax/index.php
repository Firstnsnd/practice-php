<html>
<head>
    <meta charset="utf-8">
    <title>实时编辑表格</title>
    <style type="text/css">
        table.data {
            font-family: verdana,arial,sans-serif;
            font-size:11px;
            color:#333333;
            border-width: 1px;
            border-color: #999999;
            border-collapse: collapse;
        }
        table.data th {
            background:#b5cfd2 url('cell-blue.jpg');
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #999999;
            width:190px;
        }
        table.data td {
            background:#dcddc0 url('cell-grey.jpg');
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #999999;
            width:190px;
            text-align:center;
        }
        table.data th a, table.data td a{
            text-decoration:none;
            color:green;
        }
    </style>
</head>
<body>
<div class="container">
    <table class="data">
        <tr>
            <th>姓名</th>
            <th>年龄</th>
            <th>
                <a id="addBtn"  href="javascript:;"/>添加</a>
            </th>
        </tr>
    </table>
</div>
</body>
<script type="text/javascript" src="jquery.min.js"> </script>
<script type="text/javascript">
    $(function() {
        // 获取class为data的对象<table>
        var g_table=$("table.data");
        // ajax  数据初始化展示
        $.ajax({
            type: "GET",
            url: 'indexController.php',
            dataType: 'json',
            cache: false,
            data: {
                action:'show'
            },
            success: function(data) {
                for(var i=0,j=data.length;i<j;i++){
                    var data_dom=create_row(data[i]);
                    g_table.append(data_dom);
                }
            },
        });

        $("#addBtn").click(function(){
            // 创建前2个<td>
            var addRow=$("<tr></tr>");
            for(var i=0;i<2;i++){
                var col_td=$("<td><input class='txtField' type='text' value='' /></td>");
                addRow.append(col_td);
            }
            // 创建第3个<td>
            var col_opt=$("<td></td>");
            var confirmBtn=$("<a href='javascript:;'>确认 </a>");
            confirmBtn.click(function(){
                // 获取当前对象<tr>
                var currentRow=$(this).parent().parent();
                // 遍历出当前对象<tr>的所有<input>
                var input_data=currentRow.find("input");
                var post_data={};
                //遍历该行的数据，装入post_data数组中
                for(var i=0,j=input_data.length;i<j;i++){
                    post_data['col_'+i]=input_data[i].value;
                }
                //ajax
                $.ajax({
                    type: "POST",
                    url: 'indexController.php',
                    dataType: 'json',
                    cache: false,
                    data: {
                        action:'add',
                        post_data:post_data
                    },
                    success: function(data) {
                        if(data>0){
                            post_data['id']=data;
                            // 得到新的拼接好的html，并替换
                            var postAddRow=create_row(post_data);
                            currentRow.replaceWith(postAddRow);
                        }else{
                            alert('添加失败！');
                        }
                    },
                });
            });
            var cancelBtn=$("<a href='javascript:;'>取消</a>");
            cancelBtn.click(function(){
                // 取消就删除刚添加的空行
                $(this).parent().parent().remove();
            });
            // 拼接好新的的行，然后替换
            col_opt.append(confirmBtn);
            col_opt.append(cancelBtn);

            addRow.append(col_opt);
            g_table.append(addRow);
        });

        /**
         * edit 编辑
         */
        function edit(){
            // 获取当前对象<a>属性dataid的值
            var data_id=$(this).attr("dataid");
            // 获取当前对象<a>
            var meButton=$(this);
            // 获取当前对象<tr>
            var meRow=$(this).parent().parent();
            var editRow=$("<tr></tr>");

            // 将原来的td中的值，提取出来，添加到editTd的value中，最后插入到editRow中
            for(var i=0;i<2;i++){
                var editTd=$("<td><input type='text'/></td>");
                var v=meRow.find('td:eq('+i+')').html();
                editTd.find('input').val(v);
                editRow.append(editTd);
            }
            var opt_td=$("<td></td>");
            var saveButton=$("<a href='javascript:;'>保存 </a>");
            saveButton.click(function(){
                //获取当前对象<tr>
                var currentRow=$(this).parent().parent();
                // 遍历出当前对象<tr>的所有<input>
                var input=currentRow.find("input");
                var post_data={};
                //遍历该行的数据，装入post_data数组中
                for(var i=0,j=input.length;i<j;i++){
                    post_data['col_'+i]=input[i].value;
                }
                post_data['id'] = data_id;
                // ajax
                $.ajax({
                    type: "POST",
                    url: 'indexController.php',
                    dataType: 'json',
                    cache: false,
                    data: {
                        action:'edit',
                        post_data:post_data
                    },
                    success: function(data) {
                        if(data == '1'){
                            // 得到新的拼接好的html，并替换
                            var updateRow=create_row(post_data);
                            currentRow.replaceWith(updateRow);
                        }else{
                            alert('编辑失败！');
                        }
                    },
                });
            });
            var cancelButton=$("<a href='javascript:;'>取消</a>");
            cancelButton.click(function(){
                var currentRow=$(this).parent().parent();
                // 给当前对象<tr>，更换点击事件为edit和del
                meRow.find('a:eq(0)').click(edit);
                meRow.find('a:eq(1)').click(del);
                currentRow.replaceWith(meRow);
            });
            // 拼接好新的的行，然后替换
            opt_td.append(saveButton);
            opt_td.append(cancelButton);

            editRow.append(opt_td);
            meRow.replaceWith(editRow);
        }

        /**
         * del 删除
         */
        function del(){
            // 获取当前对象<a>属性dataid的值
            var data_id=$(this).attr("dataid");
            // 获取当前对象<a>
            var meButton=$(this);
            // 弹出选择框
            if(confirm("确认要删除？")){
                // ajax post 操作
                $.ajax({
                    type: "POST",
                    url: 'indexController.php',
                    dataType: 'json',
                    cache: false,
                    data: {
                        action:'del',
                        id:data_id,
                    },
                    success: function(data) {
                        if(data == '1'){
                            // 删除当前行tr
                            $(meButton).parent().parent().remove();
                        }else{
                            alert('删除失败！');
                        }
                    },
                });
            }
        }

        /**
         * create_row   把数据进行相应的格式展现出来
         * @param  data_item 数据对象
         * @return string  返回拼接好的html
         */
        function create_row(data_item){
            var row_obj=$("<tr></tr>");
            for(var k in data_item){
                if("id" != k){
                    var col_td=$("<td></td>");
                    col_td.html(data_item[k]);
                    row_obj.append(col_td);
                }
            }
            var editButton=$("<a href='javascript:;'>编辑&nbsp;|</a>");
            editButton.attr("dataid",data_item['id']);
            editButton.click(edit);

            var delButton=$("<a href='javascript:;'>&nbsp;删除 </a>");
            delButton.attr("dataid",data_item['id']);
            delButton.click(del);

            var opt_td=$("<td></td>");
            opt_td.append(editButton);
            opt_td.append(delButton);
            row_obj.append(opt_td);
            return row_obj;
        }

    });
</script>
</html>

