<?php
namespace app\manage\controller;
use ez\core\Controller;
use ez\core\Ez;
use ez\core\Network;
use ez\core\Route;
use ez\core\Session;

/**
 * 系统后台总控制器
 * 
 * @author lxj
 */
class ManageController extends Controller
{
    /**
     * @var array 登录用户信息
     */
    public $user = [];
    
    
    /**
     * 初始化
     * 
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        
        if (Ez::config('manageIpControl')) {
            self::_manageIpFilter();
        }
        
        $this->user = Session::get('user');
        
        if (empty($this->user['id'])) {
            $this->redirect('manage/login/index');
        }
        
        $this->checkAuth();
    }
    
    /**
     * 权限检查
     * 
     * @access protected
     */
    protected function checkAuth()
    {
        
    }
    
    /**
     * IP过滤
     *
     * @param array $ips 允许ip
     */
    protected static function _manageIpFilter($ips = [])
    {
        if (empty($ips)) {
            $ips = [
                '127.0.0.1',
                '0.0.0.0',
            ];
        }

        /* 系统后台 */
        if (is_array($ips) && count($ips) > 0 && !in_array(Network::get_ip(), $ips)) {
            header('Location: ' . HTTPHOST);
            exit;
        }
    }
}
