<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title><?=$app['title']?></title>
    <link href="/layui/css/layui.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <?php foreach ($menus as $val) { ?>
            <li <?php if(CONTROLLER_NAME == ucfirst($val['controller']) && ACTION_NAME == $val['action']) echo 'class="layui-this"'; ?> onclick="location.href='<?=ez\core\Route::createUrl("{$val['controller']}/{$val['action']}")?>'"><?=$val['title']?></li>
            <?php } ?>
        </ul>
        <div class="layui-tab-content"><?php include $manage_layout; ?></div>
    </div>
</body>
</html>
