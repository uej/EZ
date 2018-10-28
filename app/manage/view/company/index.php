<?php 
use app\manage\model\Company;
?>
<form action="" method="get">
    关键字：<div class="layui-inline">
        <input class="layui-input" name="key" value="<?=htmlspecialchars(trim($_GET['key']))?>" id="demoReload" autocomplete="off">
    </div>
    <input type="submit" class="layui-btn" value="搜索">
</form>
<table class="layui-table">
    <thead>
        <tr>
            <th>id</th>
            <th>商户名称</th>
            <th>联系人</th>
            <th>电话</th>
            <th>地址</th>
            <th>上级商户</th>
            <th>创建时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $val) { ?>
        <tr>
            <td><?=$val['id']?></td>
            <td><?=$val['name']?></td>
            <td><?=$val['contact']?></td>
            <td><?=$val['phone']?></td>
            <td><?=$val['address']?></td>
            <td><?=Company::get('name', ['id' => $val['parentId']])?></td>
            <td><?=date('Y-m-d H:i:s', $val['createTime'])?></td>
            <td><?=$val['status']?></td>
            <td>
                <a href="<?=ez\core\Route::createUrl('user/index', ['companyId' => $val['id']])?>" class="layui-btn layui-btn-xs">商户用户</a>
                <?php include SITE_PATH . '/template/manage/dataHandle.php'; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
