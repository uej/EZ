<?php 
use app\manage\model\Company;
use app\manage\model\Role;
?>
<form action="" method="get" class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label" style="padding-left: 0; width: 60px; text-align: left;">关键字：</label>
        <div class="layui-input-inline">
            <input class="layui-input" name="key" value="<?=htmlspecialchars(trim($_GET['key']))?>" id="demoReload" autocomplete="off">
        </div>
        <?php if($user['roleId'] == 1) { ?>
        <div class="layui-input-inline">
            <select name="companyId">
                <option value="">请选择商户</option>
                <?php foreach ($company as $val) { ?>
                <option value="<?=$val['id']?>" <?php if($_GET['companyId'] == $val['id']) echo 'selected'; ?>><?=$val['name']?></option>
                <?php } ?>
            </select>
        </div>
        <?php } ?>
        <input type="submit" class="layui-btn" value="搜索">
    </div>
</form>
<script>
    var form = layui.form;
    form.render();
</script>
<table class="layui-table">
    <thead>
        <tr>
            <th>id</th>
            <th>角色名称</th>
            <th>所属商户</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $val) { ?>
        <tr>
            <td><?=$val['id']?></td>
            <td><?=$val['name']?></td>
            <td><?=Company::get('name', ['id' => $val['companyId']])?></td>
            <td><?=date('Y-m-d H:i:s', $val['createTime'])?></td>
            <td>
                <?php include SITE_PATH . '/../template/manage/dataHandle.php'; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>


