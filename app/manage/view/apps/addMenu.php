<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>添加功能菜单</title>
    <link href="<?=SITE_URL?>/layui/css/layui.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div class="layui-form" style="margin-top: 20px;">
        <div class="layui-form-item">
            <label class="layui-form-label">菜单标题</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="title" class="layui-input" lay-verify="required" style="width: 300px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">菜单类型</label>
            <div class="layui-input-block" style="width: 300px;">
                <select name="typeId" lay-verify="required">
                    <option value="">请选择菜单类型</option>
                    <?php foreach ($menu->typeId as $key => $val) { ?>
                    <option value="<?=$key?>"><?=$val?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所属应用</label>
            <div class="layui-input-inline">
                <select name="appId" id="appId" lay-filter="appId" lay-verify="required">
                    <option value="">请选择应用</option>
                    <?php foreach ($apps as $val) { ?>
                    <option value="<?=$val['id']?>"><?=$val['title']?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="layui-form-label">上级菜单</label>
            <div class="layui-input-inline" lay-filter="parentId">
                <select name="parentId" id="parentId" lay-verify="required">
                    <option value="">请选择菜单</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">请求类型</label>
            <div class="layui-input-block" style="width: 300px;">
                <select name="requestType">
                    <?php foreach ($menu->requestType as $key => $val) { ?>
                    <option value="<?=$key?>"><?=$val?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">app</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="app" lay-verify="required" class="layui-input" style="width: 300px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">controller</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="controller" lay-verify="required" class="layui-input" style="width: 300px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">action</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="action" lay-verify="required" class="layui-input" style="width: 300px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="sort" lay-verify="number" class="layui-input" style="width: 300px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">样式</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="className" class="layui-input" style="width: 300px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" checked title="开启">
                <input type="radio" name="status" value="0" title="关闭">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">执行操作前是否询问</label>
            <div class="layui-input-block">
                <input type="radio" name="askSure" value="1" title="是">
                <input type="radio" name="askSure" value="0" checked title="否">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">携带参数名</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="param" placeholder="请输入请求url后需要携带的参数字段，无则不填" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">参数来源字段</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="field" placeholder="请输入参数来源字段名，无则不填" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="dosubmit">立即提交</button>
            </div>
        </div>
    </div>
    <script src="<?=SITE_URL?>/win10ui/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="<?=SITE_URL?>/layui/layui.all.js" type="text/javascript"></script>
    <script>
        var form = layui.form;
        
        //表单验证
        form.verify({
            pathinfo: [
                /^[_a-zA-Z0-9\/]*$/
                ,'路由格式不正确'
            ],
            logo: [
                /^[_a-zA-Z\.\/\-\s\d]+$/
                ,'logo格式不正确'
            ],
            logoColor: [
                /^[_a-zA-Z0-9\/]*$/
                ,'logo底色格式不正确'
            ],
        });  
        
        //监听提交
        form.on('submit(dosubmit)', function(data) {
            $.ajax({
                url: "<?= ez\core\Route::createUrl('addMenu')?>",
                data: data.field,
                type: "post",
                dataType: "json",
                success: function(res) {
                    if(res.status == 1) {
                        layer.alert(res.info, {icon: 1}, function() {
                            var index = parent.layer.getFrameIndex(window.name); 
                            parent.layer.close(index);
                        });
                    } else {
                        layer.alert(res.info, {icon: 2});
                    }
                },
                error: function() {
                    layer.alert('页面超时，请刷新重试', {icon: 0});
                }
            });
            return false;
        });
        
        //监听select联动
        form.on('select(appId)', function(data){
            if (data.value > 0) {
                $.ajax({
                    url: "<?=ez\core\Route::createUrl('getMenuByAppId')?>",
                    dataType: "json",
                    type: 'get',
                    data: "id="+data.value,
                    success: function(res) {
                        if (res.status == 1) {
                            var menus   = res.data;
                            var html    = '<option value="">请选择菜单</option><option value="0">无上级菜单</option>';
                            for (var i=0; i<menus.length; i++) {
                                html    += '<option value="'+menus[i].id+'">'+menus[i].title+'</option>';
                            }
                            $("#parentId").html(html);
                            form.render('select');
                        } else {
                            layer.msg(res.info);
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>