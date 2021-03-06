<?php
namespace ez\core;

/**
 * 框架初始化类
 * 
 * @author lxj
 */
class Ez
{
    /**
     * 初始化框架
     * 
     * @access public
     */
    public static function _init()
    {
        /* PHP版本检测 */
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            header("Content-type:text/html;charset=utf-8");
            die('PHP版过低! 至少5.4。谢谢合作!');
        }
        
        /* 自动加载注册 */
        if (!function_exists('ezAutoload')) {
            spl_autoload_register(function($classname) {
                if (false !== strpos($classname, '\\')) {

                    /* 定位路径 */
                    $filename = SITE_PATH . '/' . str_replace('\\', '/', $classname . '.php');

                    /* 引入文件 */
                    if (is_file($filename)) {
                        include $filename;
                    }
                }
                return;
            }, TRUE, TRUE);
        }
        
        set_error_handler(["\\ez\\core\\Error", "errorHandler"]);
        set_exception_handler(["\\ez\\core\\Error", "exceptionHandler"]);
        if (empty(self::config('debug'))) {
            ini_set('display_errors', 0);
        }
        
        /* 是否开启面压缩 */
        if (self::config('openGzip')) {
            ob_start('ob_gzhandler');
        }
        
        /* session驱动 */
        if (self::config('sessionAutoStart')) {
            $sessionDriver  = self::config('sessionDriver');
            if (empty($sessionDriver)) {
                $sessionSavePath = self::config('sessionSavePath');
                if (!empty($sessionSavePath) && is_dir($sessionSavePath)) {
                    session_save_path($sessionSavePath);
                }
                session_start();
            } else {
                if (class_exists(self::config('sessionDriver'))) {
                    new $sessionDriver();
                }
            }
        }
        
        /* 设置时区 */
        date_default_timezone_set(self::config('timeZone'));
        
        /* 常量设置 */
        if (!defined('HTTPHOST')) {
            if (PHP_SAPI != 'cli') {
                if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS']=='off') {
                    $http   = 'http://';
                } else {
                    $http   = 'https://';
                }
                
                $http_host  = filter_input(INPUT_SERVER, 'HTTP_HOST');
                if (!in_array($http_host, self::config('httphost'))) {
                    throw new \Exception('Illegal httphost:' . $http_host);
                }
                define('HTTPHOST', $http . $http_host);
                
                $_root  = dirname(filter_input(INPUT_SERVER, 'SCRIPT_NAME'));
                $_root  = str_replace('\\', '/', $_root);
                define('__ROOT__',  (($_root=='/' || $_root=='\\') ? '' : rtrim($_root,'/')));
                
                if (!defined('SITE_URL'))   define('SITE_URL',   HTTPHOST . __ROOT__);
                if (!defined('__CSS__'))    define('__CSS__',    SITE_URL . '/css');
                if (!defined('__JS__'))     define('__JS__',     SITE_URL . '/js');
                if (!defined('__IMG__'))    define('__IMG__',    SITE_URL . '/images');
                if (!defined('__VIDEO__'))  define('__VIDEO__',  SITE_URL . '/videos');
            }
        }
    }
    
    /**
     * 程序开始
     * 
     * @access public
     */
    public static function start()
    {
        try {
            self::_init();
            $app = new Application();
            $app->run();
        } catch (Exception $ex) {
            Log::addLog($ex->__toString());
        }
        
        if (self::config('openGzip')) {
            ob_end_flush();
        }
    }
    
    /**
     * 获取、设置配置函数
     * 
     * @param mixed $name 配置的名称或者 key=>value 对
     * @param mixed $value 配置$name的value
     * 
     * @return mixed 
     */
    public static function config($name=null, $value=null)
    {
        global $_config;

        /* 无参数时获取所有 */
        if (empty($name)) return $_config;

        /* 优先执行设置获取或赋值 */ 
        if (is_string($name)) {

            /* 值过滤 */
            if (is_null($value)) {
                return isset($_config[$name]) ? $_config[$name] : null;
            }

            /* 设置配置定义 */
            $GLOBALS['_config'][$name] = $value;
            return;
        }

        /* 批量设置 */ 
        if(is_array($name))
            return $GLOBALS['_config'] = array_merge($_config,array_change_key_case($name));

        return null;
    }
}



