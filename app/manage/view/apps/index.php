<table id="data" lay-filter="data"></table>
<?php include SITE_PATH . '/../template/manage/js.php'; ?>

<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script>
    var table = layui.table;
  
    table.render({
        elem: '#data'
        ,height: 312
        ,url: '<?=ez\core\Route::createUrl('index')?>' //数据接口
        ,page: true //开启分页
        ,cols: [[ //表头
            {field: 'id', title: 'ID', sort: true, fixed: 'left'}
            ,{field: 'app', title: '应用标识'}
            ,{field: 'title', title: '应用标题'}
            ,{field: 'entryUrl', title: '前台地址'}
            ,{field: 'manageEntryUrl', title: '后台地址'}
            ,{field: 'logo', title: '图标'}
            ,{field: 'sort', title: '排序'}
            ,{field: 'status', title: '状态'}
            ,{fixed: 'right', title:'操作', toolbar: '#actionBar'}
        ]]
    });
    
    //监听行工具事件
    table.on('tool(data)', function(obj) {
        var data = obj.data;
        if(obj.event === 'del'){
            layer.confirm('真的删除行么', function(index){
                obj.del();
                layer.close(index);
            });
        }
        if(obj.event === 'edit'){
            layer.prompt({
                formType: 2
                ,value: data.email
            }, function(value, index){
                obj.update({
                  email: value
                });
                layer.close(index);
            });
        }
    });
</script>