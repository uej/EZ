<?php 
use app\manage\model\Company;
use app\manage\model\Role;
?>
<table class="layui-table">
    <thead>
        <tr>
            <th>id</th>
            <th>账号</th>
            <th>姓名</th>
            <th>商户</th>
            <th>角色</th>
            <th>电话</th>
            <th>创建时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $val) { ?>
        <tr>
            <td><?=$val['id']?></td>
            <td><?=$val['account']?></td>
            <td><?=$val['name']?></td>
            <td><?=Company::get('name', ['id' => $val['companyId']])?></td>
            <td><?=Role::get('name', ['id' => $val['roleId']])?></td>
            <td><?=$val['phone']?></td>
            <td><?=date('Y-m-d H:i:s', $val['createTime'])?></td>
            <td><?=$val['status']?></td>
            <td>
                <?php include SITE_PATH . '/../template/manage/dataHandle.php'; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

