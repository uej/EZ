<?php
namespace app\manage\controller;
use app\manage\model\Apps;
use app\manage\model\Menu;

/**
 * 应用模块控制器
 * 
 * @author lxj
 */
class AppsController extends ManageController {
    
    /**
     * 应用列表
     * 
     * @access public
     */
    public function index() {
        $key    = trim(filter_input(INPUT_GET, 'key'));
        $where  = NULL;
        if (!empty($key)) {
            $where  = [
                'OR'    => [
                    'app'   => $key,
                    'title[~]' => $key,
                ]
            ];
        }
        
        $apps   = new Apps();
        $data   = $apps->findPage(10, $where);
        $this->assign($data);
        $this->render();
    }
    
    /**
     * 添加应用
     * 
     * @access public
     */
    public function addApp() {
        if (empty($_POST)) {
            $this->display();
        } else {
            $apps   = new Apps();
            if ($apps->addApp()) {
                $this->success('添加成功');
            } else {
                $this->error($apps->error);
            }
        }
    }
    
    /**
     * 编辑应用
     * 
     * @access public
     */
    public function editApp() {
        if (empty($_POST)) {
            $id = intval($_GET['id']);
            if (empty($id)) {
                $this->error("参数错误");
            }
            
            $data   = Apps::get('*', ['id' => $id]);
            if (empty($data)) {
                $this->error("应用不存在");
            }
            
            $this->assign('data', $data);
            $this->display();
        } else {
            $apps   = new Apps();
            if ($apps->editApp()) {
                $this->success('编辑成功');
            } else {
                $this->error($apps->error);
            }
        }
    }
    
    /**
     * app删除
     * 
     * @access public
     */
    public function delApp() {
        $id = intval($_GET['id']);
        
        /* 删除验证 */
        if (Menu::has(['appId' => $id, 'status' => 1])) {
            $this->error("该应用还有正常功能或菜单，不能删除");
        }
        
        $result = Apps::update(['status' => 0], ['id' => $id]);
        if ($result->errorCode() === '00000') {
            $this->success("删除成功");
        } else {
            $this->error("删除失败");
        }
    }
    
    /**
     * 应用菜单
     * 
     * @access public
     */
    public function menu() {
        $menu   = new Menu();
        
        /* 搜索条件 */
        $where  = [];
        $key    = trim(filter_input(INPUT_GET, 'key'));
        if (!empty($_GET['appId'])) {
            $where['appId'] = intval($_GET['appId']);
        }
        if (!empty($_GET['typeId'])) {
            $where['typeId']    = intval($_GET['typeId']);
        }
        if (!empty($key)) {
            $where['title[~]']  = $key;
        }
        
        $data   = $menu->findPage(10, $where);
        $this->assign('type', $menu->typeId);
        $this->assign('requestType', $menu->requestType);
        $this->assign($data);
        $this->render();
    }
    
    /**
     * 添加菜单
     * 
     * @access public
     */
    public function addMenu() {
        $menu   = new Menu();
        
        if (empty($_POST)) {
            $this->assign('menu', $menu);
            $this->assign('apps', Apps::select(['id', 'title'], ['status' => 1]));
            $this->display();
        } else {
            if ($menu->addMenu()) {
                $this->success('添加成功');
            } else {
                $this->error($menu->error);
            }
        }
    }
    
    /**
     * 编辑菜单
     * 
     * @access public
     */
    public function editMenu() {
        $menu   = new Menu();
        
        if (empty($_POST)) {
            $id = intval($_GET['id']);
            $data   = $menu->get('*', ['id' => $id]);
            $this->assign('menu', $menu);
            $this->assign('apps', Apps::select(['id', 'title'], ['status' => 1]));
            $this->assign('data', $data);
            $this->assign('parents', $menu->select(['id', 'title'], ['status' => 1, 'appId' => $data['appId']]));
            $this->display();
        } else {
            if ($menu->editMenu()) {
                $this->success('编辑成功');
            } else {
                $this->error($menu->error);
            }
        }
    }
    
    /**
     * 获取应用菜单
     * 
     * @access public
     */
    public function getMenuByAppId() {
        $id = intval($_GET['id']);
        if ($id) {
            $data   = Menu::select(['id', 'title'], ['appId' => $id, 'status' => 1]);
            $this->ajaxReturn('获取成功', 1, $data);
        } else {
            $this->ajaxReturn('参数错误', 0);
        }
    }
    
}

