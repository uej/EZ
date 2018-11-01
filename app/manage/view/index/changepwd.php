<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>修改密码</title>
        <link href="<?=SITE_URL?>/layui/css/layui.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="layui-form" style="margin-top: 20px;">
            <div class="layui-form-item">
                <label class="layui-form-label">旧密码</label>
                <div class="layui-input-block">
                    <input type="password" autocomplete="off" name="oldPassword" class="layui-input" lay-verify="required" style="width: 300px;">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-block">
                    <input type="password" autocomplete="off" name="password" id="password" class="layui-input" lay-verify="required" style="width: 300px;">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">重复新密码</label>
                <div class="layui-input-block">
                    <input type="password" autocomplete="off" name="passwordAgain" id="passwordAgain" class="layui-input" lay-verify="required" style="width: 300px;">
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
            
            //监听提交
            form.on('submit(dosubmit)', function(data) {
                if (data.field.password != data.field.passwordAgain) {
                    layer.alert('两次输入密码不同，请重新输入');
                    return;
                }
                
                $.ajax({
                    url: "<?= ez\core\Route::createUrl('changepwd')?>",
                    data: data.field,
                    type: "post",
                    dataType: "json",
                    success: function(res) {
                        if (res.status == 1) {
                            layer.alert(res.info, {icon: 1}, function() {
                                parent.window.location = '<?=  \ez\core\Route::createUrl('popedom/logout')?>';
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
