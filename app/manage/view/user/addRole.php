<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>添加角色</title>
    <link href="<?=SITE_URL?>/layui/css/layui.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div class="layui-form" style="margin-top: 20px;">
        <div class="layui-form-item">
            <label class="layui-form-label">角色名称</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="name" class="layui-input" lay-verify="required" style="width: 300px;">
            </div>
        </div>
        
        <?php if ($user['roleId'] == 1) { ?>
        <div class="layui-form-item">
            <label class="layui-form-label">所属商户</label>
            <div class="layui-input-block" style="width: 300px;">
                <select name="companyId" id="companyId" lay-filter="companyId" lay-verify="required">
                    <option value="">请选择商户</option>
                    <option value="0">公用</option>
                    <?php foreach ($company as $val) { ?>
                    <option value="<?=$val['id']?>"><?=$val['name']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php } ?>
        
        <div class="layui-form-item">
            <label class="layui-form-label">权限</label>
            <div class="layui-input-block" style="width: 90%">
                <table class="layui-table">
                    <thead>
                        <tr>
                            <th>应用</th>
                            <th>权限</th>
                        </tr>
                    </thead>
                    <?php foreach ($apps as $val) { ?>
                    <tr>
                        <td><input type="checkbox" name="apps[]" title="<?=$val['title']?>" value="<?=$val['id']?>" lay-skin="primary"></td>
                        <td>
                            <?php foreach ($menus as $valmenu) { ?>
                            <?php if ($valmenu['appId'] == $val['id']) { ?>
                            <input type="checkbox" name="menuId[]" title="<?=$valmenu['title']?>" value="<?=$valmenu['id']?>" lay-skin="primary">
                            <?php } } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
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
            $.ajax({
                url: "<?= ez\core\Route::createUrl('addRole')?>",
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


