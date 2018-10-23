<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>添加用户</title>
    <link href="/layui/css/layui.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div class="layui-form" style="margin-top: 20px;">
        <div class="layui-form-item">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="account" class="layui-input" lay-verify="required" style="width: 300px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="name" class="layui-input" lay-verify="required" style="width: 300px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="password" class="layui-input" lay-verify="required" style="width: 300px;">
            </div>
        </div>
        
        <?php if ($user['roleId'] == 1) { ?>
        <div class="layui-form-item">
            <label class="layui-form-label">商户</label>
            <div class="layui-input-block" style="width: 300px;">
                <select name="companyId" id="companyId" lay-filter="companyId" lay-verify="required">
                    <option value="">请选择商户</option>
                    <?php foreach ($company as $val) { ?>
                    <option value="<?=$val['id']?>"><?=$val['name']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色</label>
            <div class="layui-input-block" style="width: 300px;">
                <select name="roleId" id="roleId" lay-verify="required">
                    <option value="">请选择角色</option>
                </select>
            </div>
        </div>
        <?php } else { ?>
        <div class="layui-form-item">
            <label class="layui-form-label">角色</label>
            <div class="layui-input-block" style="width: 300px;">
                <select name="roleId" id="roleId" lay-verify="required">
                    <option value="">请选择角色</option>
                    <?php foreach ($role as $val) { ?>
                    <option value="<?=$val['id']?>"><?=$val['name']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php } ?>
        
        <div class="layui-form-item">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="phone" class="layui-input" style="width: 300px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" title="正常" checked>
                <input type="radio" name="status" value="0" title="封禁">
            </div>
        </div>
        
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="dosubmit">立即提交</button>
            </div>
        </div>
    </div>
    <script src="/win10ui/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="/layui/layui.all.js" type="text/javascript"></script>
    <script>
        var form = layui.form;
        
        <?php if ($user['roleId'] == 1) { ?>
        //下拉框联动
        form.on('select(companyId)', selectrole);
        function selectrole(data) {
            if (data.value > 0) {
                var roles   = <?=json_encode($role)?>;
                var html    = '<option value="">请选择角色</option>';
                for (var i=0; i<roles.length; i++) {
                    if (roles[i].companyId == data.value || roles[i].companyId == 0) {
                        html    += '<option value="'+roles[i].id+'">'+roles[i].name+'</option>';
                    }
                }
                $("#roleId").html(html);
                form.render('select');
            } else {
                var html    = '<option value="">请选择角色</option>';
                $("#roleId").html(html);
                form.render('select');
            }
        }
        <?php } ?>
        
        //监听提交
        form.on('submit(dosubmit)', function(data) {
            $.ajax({
                url: "<?= ez\core\Route::createUrl('addUser')?>",
                data: data.field,
                type: "post",
                dataType: "json",
                success: function(res) {
                    if (res.status == 1) {
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
        
    </script>
</body>
</html>


