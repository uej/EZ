<?php
namespace ez\core;

/**
 * 框架默认路由
 * 
 * @author lxj
 */
class Route
{
    /**
     * @var 当前应用名称
     */
    public $app;
    
    /**
     * @var 当前控制器名称
     */
    public $controller;
    
    /**
     * @var 当前方法
     */
    public $action;
    
    
    /**
     * 路由构造
     * 
     * @access public
     */
    public function __construct()
    {
        $this->parsePath();
        
        defined('APP_NAME') || define('APP_NAME', $this->app);
        defined('CONTROLLER_NAME') || define('CONTROLLER_NAME', $this->controller);
        defined('ACTION_NAME') || define('ACTION_NAME', $this->action);
        
        $this->loadApp();
    }
    
    /**
     * 加载应用函数和配置
     * 
     * @access private
     */
    private function loadApp() {
        $funcPath   = SITE_PATH . '/' . APP_PATH_NAME . '/' . APP_NAME . '/function.php';
        if (is_file($funcPath)) {
            include $funcPath;
        }
        
        global $_config;
        $configPath = SITE_PATH . '/' . APP_PATH_NAME . '/' . APP_NAME . '/config.php';
        if (is_file($configPath)) {
            $config = include $configPath;
            foreach ($config as $key => $val) {
                if (in_array($key, ['defaultApp', 'urlRewrite', 'urlSuffix', 'sessionAutoStart', 'sessionSavePath', 'sessionDriver', 'sessionExpire', 'templateSuffix', 'route', 'openGzip'])) {
                    continue;
                }
                $_config[$key]  = $val;
            }
        }
    }
    
    /**
     * url解析
     * 
     * @access public
     */
    public function parsePath()
    {
        if (!empty($_SERVER['REDIRECT_PATH_INFO']) || !empty($_SERVER['PATH_INFO'])) {
            if (!empty($_SERVER['REDIRECT_PATH_INFO'])) {
                $pathInfo = trim(str_replace(Ez::config('urlSuffix'), '', filter_input(INPUT_SERVER, 'REDIRECT_PATH_INFO')), '/');
            } else {
                $pathInfo = trim(str_replace(Ez::config('urlSuffix'), '', filter_input(INPUT_SERVER, 'PATH_INFO')), '/');
            }
            
            if (!empty($pathInfo) && !preg_match('/^[a-zA-Z][_a-zA-Z0-9\/]*$/', $pathInfo)) {
                throw new \Exception('非法的pathInfo来自' . Network::get_ip());
            }
            $param = explode('/', $pathInfo);
        } else {
            $param = [];
        }
        
        /* 应用 */
        if (isset($param[0]) && !empty($param[0])) {
            $this->app  = strtolower($param[0]);
        } else {
            $this->app  = Ez::config('defaultApp');
        }
        
        /* 控制器 */
        if (isset($param[1]) && !empty($param[1])) {
            $this->controller = ucfirst($param[1]);
        } else {
            $this->controller = ucfirst(Ez::config('defaultController'));
        }
        
        /* 方法 */
        if (isset($param[2]) && !empty($param[2])) {
            $this->action = $param[2];
        } else {
            $this->action = Ez::config('defaultAction');
        }
    }
    
    /**
     * url生成，根据默认路由规则
     * 
     * @param string $url Url表达式，格式:控制器/方法
     * @param array $params 参数，键值对数组
     * @param boolen $domain 是否显示域名
     * @param boolen $redirect 是否跳转
     * @param string $entry 入口脚本文件
     * @return string URL
     * @access public
     */
    public static function createUrl($url = '', $params = [], $domain = TRUE, $redirect = FALSE)
    {
        if (empty($url)) {
            $url    = APP_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
        }
        
        /* 伪静态判断 */
        if (!Ez::config('urlRewrite')) {
            $entry  = filter_input(INPUT_SERVER, 'SCRIPT_NAME');
            $realurl    = $domain ? HTTPHOST . $entry : $entry;
        } else {
            if (!empty($_SERVER['ORIG_SCRIPT_NAME'])) {
                $entry  = filter_input(INPUT_SERVER, 'ORIG_SCRIPT_NAME');
            } else {
                $entry  = filter_input(INPUT_SERVER, 'SCRIPT_NAME');
            }
            $realurl    = $domain ? SITE_URL : str_replace('/index.php', '', $entry);
        }
        
        /* get参数组装 */
        $get = '';
        if (is_array($params) && !empty($params)) {
            foreach ($params as $key => $value) {
                if (strpos($get, '?') !== FALSE) {
                    $get .= "&$key=" . urlencode($value);
                } else {
                    $get .= "?$key=" . urlencode($value);
                }
            }
        }
        
        $path  = explode('/', $url);
        $total = count($path);
        if ($total == 1) {
            $realurl .= '/' . APP_NAME . '/' . CONTROLLER_NAME . '/' . $path[0] . Ez::config('urlSuffix');
        } else if ($total == 2) {
            $realurl .= '/' . APP_NAME . '/' . $path[0] . '/' . $path[1] . Ez::config('urlSuffix');
        } else if ($total == 3) {
            $realurl .= '/' . $path[0] . '/' . $path[1] . '/' . $path[2] . Ez::config('urlSuffix');
        }
        
        $realurl .= $get;
        if ($redirect) {
            self::redirect($realurl);
        } else {
            return $realurl;
        }
    }
    
    /**
     * URL重定向
     *
     * @param string  $url  地址
     * @param integer $time 时间
     * @param string  $msg  跳转时的提示信息
     * @access public
     */
    public static function redirect($url, $time = 0, $msg = '')
    {
        /* 多行URL地址支持 */
        $url = str_replace(array("\n", "\r"), '', $url);

        /* 提示信息 */
        if (empty($msg)) {
            $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
        }

        if (!headers_sent()) {
            /* 跳转 */
            if (0 === $time) {
                header("Location: ".$url);
            } else {
                header("refresh:{$time};url={$url}");
                $str = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                $msg = $str . $msg;
                echo($msg);
            }
            exit();
        } else {
            $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
            if ($time != 0) $str .= $msg;
            exit($str);
        }
    }
    
}

