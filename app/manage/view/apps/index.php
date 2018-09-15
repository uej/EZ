<table class="layui-table">
    <thead>
        <tr>
            <th>id</th>
            <th>应用标识</th>
            <th>应用标题</th>
            <th>前台地址</th>
            <th>后台地址</th>
            <th>创建时间</th>
            <th>logo</th>
            <th>排序</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $val) { ?>
        <tr>
            <td><?=$val['id']?></td>
            <td><?=$val['app']?></td>
            <td><?=$val['title']?></td>
            <td><?=$val['entryUrl']?></td>
            <td><?=$val['manageEntryUrl']?></td>
            <td><?=date('Y-m-d H:i:s', $val['createTime'])?></td>
            <td><?=$val['logo']?></td>
            <td><?=$val['sort']?></td>
            <td><?=$val['status']?></td>
            <td>
                <a href="<?=ez\core\Route::createUrl('company/user', ['appId' => $val['id']])?>" class="layui-btn layui-btn-xs">功能菜单</a>
                <?php include SITE_PATH . '/../template/manage/dataHandle.php'; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>