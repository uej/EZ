<?php
namespace app\manage\controller;
use ez\core\Controller;
use ez\core\Ez;
use ez\core\Network;
use ez\core\Session;
use app\manage\model\Apps;
use app\manage\model\Menu;

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
        
        $this->user = Session::get('manage_user');
        
        if (empty($this->user['id'])) {
            $this->redirect('manage/popedom/index');
        }
        
        $this->checkAuth();
        $this->getMenu();
        $this->assign('verison', time());
    }
    
    /**
     * 权限检查
     * 
     * @access protected
     */
    protected function checkAuth()
    {
        $nowActionId = Menu::get('id', [
            'app'           => APP_NAME,
            'controller'    => CONTROLLER_NAME,
            'action'        => ACTION_NAME,
        ]);
        
        if (empty($nowActionId)) {
            return;
        }
        if ($this->user['roleId'] == 1) {
            return;
        }
        if (in_array($nowActionId, explode(',', $this->user['role']['menuId']))) {
            return;
        } else {
            $this->error('无权访问');
        }
    }

    /**
     * 菜单获取
     * 
     * @access protected
     */
    protected function getMenu()
    {
        /* 应用菜单列表 */
        $app    = Apps::get(['id', 'title'], ['app' => APP_NAME]);
        $menuWhere  = [
            'appId'     => $app['id'],
            'typeId'    => 1,
            'ORDER'     => ['sort' => 'ASC'],
            'status'    => 1,
        ];
        if ($this->user['roleId'] != 1) {
            $menuWhere['id']    = explode(',', $this->user['role']['menuId']);
        }
        $menus  = Menu::select('*', $menuWhere);
        $this->assign('tpl_manage_menus', $menus);
        $this->assign('tpl_manage_app', $app);
        
        /* 菜单内功能 */
        $nowMenu    = Menu::get('id', ['app' => APP_NAME, 'controller' => CONTROLLER_NAME, 'action' => ACTION_NAME, 'typeId' => 1]);
        if ($nowMenu) {
            $where  = [
                'parentId'  => $nowMenu,
                'ORDER'     => ['sort' => 'ASC'],
                'status'    => 1,
            ];
            if ($this->user['roleId'] != 1) {
                $where['id']    = explode(',', $this->user['role']['menuId']);
            }
            $dataMenuWhere  = $menuMenuWhere    = $where;
            $dataMenuWhere['typeId']    = 2;
            $menuMenuWhere['typeId']    = 3;
            $dataMenu   = Menu::select('*', $dataMenuWhere);
            $menuMenu   = Menu::select('*', $menuMenuWhere);
            $this->assign('tpl_manage_dataMenu', $dataMenu);
            $this->assign('tpl_manage_menuMenu', $menuMenu);
        }
    }

    /**
     * IP过滤
     *
     * @param array $ips 允许ip
     * @access protected
     */
    protected static function _manageIpFilter($ips = [])
    {
        if (empty($ips)) {
            $ips = [
                '127.0.0.1',
                '0.0.0.0',
                '192.168.109.1',
                '10.10.10.151',
                '10.10.10.12',
            ];
        }

        /* 系统后台 */
        if (is_array($ips) && count($ips) > 0 && !in_array(Network::get_ip(), $ips)) {
            header('Location: ' . SITE_URL);
            exit;
        }
    }
    
    /**
     * 带公共部分的界面输出
     * 
     * @param string $view 模板路径
     * @access public
     */
    public function render($view = '')
    {
        if (empty($view)) {
            $view = ACTION_NAME;
        }
        if (is_file($view)) {
            $layout = $view;
        } else {
            $layout = SITE_PATH . '/' .APP_PATH_NAME . '/' . APP_NAME .'/view/' . strtolower(CONTROLLER_NAME) . '/' . $view . '.php';
        }
        
        $this->assign('tpl_manage_layout', $layout);
        $this->display(SITE_PATH . '/template/manage/layout.php');
    }
    
    /**
     * 上传文件至开放目录
     * 
     * @access public
     */
    public function openupload() {
        $upload = new \ez\driver\Upload([
            'uploadPath'    => ENTRY_PATH . '/uploads/',
        ]);
        $res    = $upload->doUpload();
        $res['savePath']    = str_replace(ENTRY_PATH, '', $res['savePath']);
        die(json_encode($res));
    }
}
