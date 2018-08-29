<?php 
/**
 * 数据行操作页
 * 
 * @author lxj
 */
foreach ($dataMenu as $handle) { ?>
<a href="javascript:handleDo('<?=ez\core\Route::createUrl("{$handle['app']}/{$handle['controller']}/{$handle['action']}", ['id' => $val['id']])?>', <?=$handle['askSure']?>, '<?=$handle['title']?>', <?=$handle['requestType']?>)" class="<?=$handle['className']?>"><?=$handle['title']?></a>
<?php } ?>


