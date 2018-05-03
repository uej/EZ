<?php
/**
 * 应用唯一入口
 * 
 * @author lxj
 */

/* 入口目录 */
define('SITE_PATH', getcwd());

/* 应用配置 */
$_config = include(__DIR__ . '/../config/config.php');

/* 应用文件夹 */
define('APP_PATH_NAME', 'app');

/* 引入函数 */
require(__DIR__ . '/../ez/autoload.php');
require(__DIR__ . '/../function/function.php');

/* 应用开始 */
\ez\core\Ez::start();
