<?php
/**
 * 框架函数库
 * 
 * @author lxj
 */


/**
 * 浏览器友好输出
 * 
 * @param mixed $a 打印变量
 */
function dump($a){
    echo "<pre>";
    var_dump($a);
    echo "</pre>";
}

/**
 * 计时测试
 */
function testtime($id) {
    $path   = SITE_PATH . '/runtime/data/testtime/';
    mkdir($path, 0777, true);
    $filename = $path . "$id-" . time();
    fopen($filename, 'w+');
    
}

