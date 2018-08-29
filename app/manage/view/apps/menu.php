<table class="layui-table">
    <thead>
        <tr>
            <th>id</th>
            <th>名称</th>
            <th>应用</th>
            <th>控制器</th>
            <th>方法</th>
            <th>类型</th>
            <th>上级id</th>
            <th>所属应用</th>
            <th>创建时间</th>
            <th>排序</th>
            <th>请求类型</th>
            <th>是否询问</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $val) { ?>
        <tr>
            <td><?=$val['id']?></td>
            <td><?=$val['title']?></td>
            <td><?=$val['app']?></td>
            <td><?=$val['controller']?></td>
            <td><?=$val['action']?></td>
            <td><?=$type[$val['typeId']]?></td>
            <td><?=$val['parentId']?></td>
            <td><?=app\manage\model\Apps::get('title', ['id' => $val['appId']])?></td>
            <td><?=date('Y-m-d H:i:s', $val['createTime'])?></td>
            <td><?=$val['sort']?></td>
            <td><?=$requestType[$val['requestType']]?></td>
            <td><?=$val['askSure']?></td>
            <td><?=$val['status']==1 ? '正常' : '关闭'?></td>
            <td>
                <?php include SITE_PATH . '/../template/manage/dataHandle.php'; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

