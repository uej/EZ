<?php
namespace ez\core;

/**
 * 框架控制器
 * 
 * @author lxj
 */
class Controller
{
    /**
     * @var string 模板文件路径
     */
    public $templateDir;

    /**
     * @var string 模板后缀名
     */
    public $suffix;
    
    /**
     * @var array 模板变量
     */
    public $templateVariable = [];
    
    
    /**
     * 构造函数
     * 
     * @access public
     */
    public function __construct()
    {
        $this->suffix = Ez::config('templateSuffix');
        $this->templateDir = '../view/' . strtolower(CONTROLLER_NAME) . '/';
    }
    
    /**
     * 是否AJAX请求
     *
     * @access protected
     * @return bool
     */
    protected function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if ('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                return true;
			}
        }
        return false;
    }
    
    /**
     * 添加模板变量
     * 
     * @param mixed $name 变量名/模板变量键值对
     * @param mixed $value 变量值
     * @access protected
     */
    protected function assign($name, $value = '')
    {
        if (is_array($name)) {
            $this->templateVariable = array_merge($this->templateVariable, $name);
            return;
        } elseif (is_string($name) && !empty($name)) {
            $this->templateVariable = array_merge($this->templateVariable, ["$name" => $value]);
            return;
        }
    }
    
    /**
     * 显示模板
     * 
     * @param mixed $view 模板名称，小写，为空则根据方法名自动定位，为数组时自动定位模板
     * @param array $data 传递到模板的变量数组
     * 
     * @access protected
     */
    protected function display($view = '', $data = [])
    {
        /* 未指定模板，在默认位置寻找模板加载 */
        if (is_array($view)) {
            $this->templateVariable = array_merge($this->templateVariable, $view);
            extract($this->templateVariable);
            $template = SITE_PATH . '/../' .APP_PATH_NAME . '/' . APP_NAME .'/view/' . strtolower(CONTROLLER_NAME) . '/' . strtolower(ACTION_NAME) . '.php';
            if(!is_file($template)) {
                throw new \Exception('template not exists');
            }
            include $template;
            
        } else if (is_string($view)) {
            if (is_array($data) && !empty($data)) {
                $this->templateVariable = array_merge($this->templateVariable, $data);
            }
            extract($this->templateVariable);
            
            if (empty($view)) {
                $view = ACTION_NAME;
            }
            if (is_file($view)) {
                include $view;
            } else {
                $template = SITE_PATH . '/../' .APP_PATH_NAME . '/' . APP_NAME .'/view/' . strtolower(CONTROLLER_NAME) . '/' . strtolower($view) . '.php';
                if (!is_file($template)) {
                    throw new \Exception('template not exists');
                }
                include $template;
            }
        }
    }
    
    /**
     * Action跳转(URL重定向)
     * 
     * @param string $url 跳转的URL表达式
     * @param array $params 其它URL参数
     * @param integer $delay 延时跳转的时间 单位为秒
     * @param string $msg 跳转提示信息
     * @return void
     * 
     * @access protected
     */
    protected function redirect($url, $params = [], $delay = 0, $msg='')
    {
        $url = Route::createUrl($url, $params);
        Route::redirect($url, $delay, $msg);
    }
    
    /**
     * 成功跳转
     * 
     * @access protected
     */
    protected function success($msg = '操作成功', $delay = 1) {
        if ($this->isAjax()) {
            $this->ajaxReturn($msg);
        } else {
            if (!isset($this->templateVariable['jumpUrl'])) {
                $url = filter_input(INPUT_SERVER, 'HTTP_REFERER');
                $this->assign('jumpUrl', $url);
            }

            $this->assign('message', $msg);
            $this->assign('status', 1);
            $this->assign('waitSecond', $delay);
            $this->display(__DIR__.'/../template/success.php');
            die;
        }
    }
    
    /**
     * 失败跳转
     * 
     * @access protected
     */
    protected function error($msg = '操作失败', $delay = 5) {
        if ($this->isAjax()) {
            $this->ajaxReturn($msg, 0);
        } else {
            if (!isset($this->templateVariable['jumpUrl'])) {
                $this->assign('jumpUrl', "javascript:history.back(-1);");
            }

            $this->assign('message', $msg);
            $this->assign('status', 0);
            $this->assign('waitSecond', $delay);
            $this->display(__DIR__.'/../template/success.php');
            die;
        }
    }
    
    /**
     * Ajax方式返回数据到客户端
     *
     * @access protected
     *
     * @param string $info 提示信息
     * @param integer $status 返回状态
     * @param mixed $data 要返回的数据
     * @param string $type ajax返回类型 JSON XML
     *
     * @return void
     */
    protected function ajaxReturn($info = '', $status = 1, $data = '', $type = 'JSON')
    {
        $result = [
            'status'    => $status,
            'info'      => $info,
            'data'      => $data,
        ];
		
        if (strtoupper($type) == 'JSON') {
            /* 返回JSON数据格式到客户端 包含状态信息 */
            header("Content-Type:text/html; charset=utf-8");
            exit(json_encode($result, JSON_UNESCAPED_UNICODE));
			
        } else if (strtoupper($type) == 'XML') {
            /* 返回xml格式数据 */
            header("Content-Type:text/xml; charset=utf-8");
            exit(\ez\tool\Xml::encode($result));
          
        } else if (strtoupper($type) == 'EVAL') {
            /* 返回可执行的js脚本 */
            header("Content-Type:text/html; charset=utf-8");
            exit($data);
        }
    }
    
}



