<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title><?=$app['title']?></title>
    <link href="/layui/css/layui.css" rel="stylesheet" type="text/css"/>
    <style>
        .pages { width: 100%; height: 38px; }
        .pages .page { float: right; line-height: 38px; font-size: 12px; }
        .pages .page .total,.pages .page .disabled,.pages .page a,.pages .page .nowpage {
            font-size: 12px; margin: 0 2px; padding: 5px 7px; border: 1px solid #e2e2e2; border-radius: 2px;
        }
        .pages .page .nowpage{ border: 1px solid #1E9FFF; color: #fff; background-color:#1E9FFF; }
        .pages .page a:hover { border: 1px solid #1E9FFF; color: #1E9FFF; }
        .pages .page .textInput{ text-align: center; border: 1px solid #e2e2e2; height: 24px; width: 40px;}
        .pages .page .turnto{ margin-left: 5px; }
        .pages .page .ye{ margin-right: 5px; }
    </style>
</head>
<body>
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <?php foreach ($menus as $val) { ?>
            <li <?php if(CONTROLLER_NAME == ucfirst($val['controller']) && ACTION_NAME == $val['action']) echo 'class="layui-this"'; ?> onclick="location.href='<?=ez\core\Route::createUrl("{$val['controller']}/{$val['action']}")?>'"><?=$val['title']?></li>
            <?php } ?>
        </ul>
        <div class="layui-tab-content">
            <script src="/win10ui/js/jquery-2.2.4.min.js" type="text/javascript"></script>
            <script src="/layui/layui.all.js" type="text/javascript"></script>
            <?php include $manage_layout; ?>
            <div class="pages">
                <?php foreach ($menuMenu as $handle) { ?>
                <a href="javascript:handleDo('<?=ez\core\Route::createUrl("{$handle['app']}/{$handle['controller']}/{$handle['action']}")?>', <?=$handle['askSure']?>, '<?=$handle['title']?>', <?=$handle['requestType']?>)" class="<?=$handle['className']?>"><?=$handle['title']?></a>
                <?php } ?>
                <div class="page"><?=$html?></div>
            </div>
            <script>
                var element = layui.element;

                // 一些事件监听
                element.on('tab(demo)', function(data) {
                    
                });

                //执行操作
                function handleDo(url, askSure, handleTitle, requestType) {
                    if (askSure == 1) {
                        layer.confirm('确定执行' + handleTitle + '吗？', function(index) {
                            requestDo(url, handleTitle, requestType);
                            layer.close(index);
                        });
                    } else {
                        requestDo(url, handleTitle, requestType);

                    }
                }

                //请求
                function requestDo(url, handleTitle, requestType) {
                    if (requestType == 1) {
                        location.href = url;
                    } else if (requestType == 2) {
                        layer.open({
                            type: 2,
                            title: handleTitle,
                            content: url,
                            area: ['80%', '80%'],
                            end: function() {
                                location.reload();
                            }
                        });
                    } else if (requestType == 2) {
                        $.ajax({
                            url: url,
                            type: "get",
                            dataType: "json",
                            success: function(res) {
                                if (res.status == 1) {
                                    layer.alert(res.info, {icon: 1});
                                    location.reload();
                                } else {
                                    layer.alert(res.info, {icon: 2});
                                }
                            },
                            error: function() {
                                layer.alert('系统错误', {icon: 0});
                            }
                        })
                    } else {
                        layer.alert('此功能配置有误');
                    }
                }
            </script>
        </div>
    </div>
</body>
</html>
