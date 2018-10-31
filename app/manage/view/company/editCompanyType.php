<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>编辑商户类型</title>
    <link href="<?=SITE_URL?>/layui/css/layui.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div class="layui-form" style="margin-top: 20px;">
        <div class="layui-form-item">
            <label class="layui-form-label">类型名称</label>
            <div class="layui-input-block">
                <input type="text" autocomplete="off" name="name" value="<?=$data['name']?>" class="layui-input" lay-verify="required" style="width: 300px;">
                <input type="hidden" name="id" value="<?=$data['id']?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">可用应用</label>
            <div class="layui-input-block" style="">
                <?php
                $dataApps   = explode(',', $data['apps']);
                foreach ($apps as $val) { ?>
                <input type="checkbox" name="apps[]" title="<?=$val['title']?>" value="<?=$val['id']?>" <?php if (in_array($val['id'], $dataApps)) echo 'checked'; ?>>
                <?php } ?>
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
                url: "<?= ez\core\Route::createUrl('editCompanyType')?>",
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

