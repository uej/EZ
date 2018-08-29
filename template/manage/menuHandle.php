<?php
/**
 * 菜单内操作页
 * 
 * @author lxj
 */
foreach ($menuMenu as $handle) { ?>
<a href="javascript:handleDo('<?=ez\core\Route::createUrl("{$handle['app']}/{$handle['controller']}/{$handle['action']}")?>', <?=$handle['askSure']?>, '<?=$handle['title']?>', <?=$handle['requestType']?>)" class="<?=$handle['className']?>"><?=$handle['title']?></a>
<?php } ?>


