<?php 
foreach ($dataMenu as $template_handle) {
    $template_key   = empty($template_handle['param']) ? 'id' : $template_handle['param'];
    $template_val   = empty($template_handle['field']) ? $val['id'] : $val[$template_handle['field']];
?>
<a href="javascript:handleDo('<?=ez\core\Route::createUrl("{$template_handle['app']}/{$template_handle['controller']}/{$template_handle['action']}", [$template_key => $template_val])?>', <?=$template_handle['askSure']?>, '<?=$template_handle['title']?>', <?=$template_handle['requestType']?>)" class="<?=$template_handle['className']?>"><?=$template_handle['title']?></a>
<?php } ?>


