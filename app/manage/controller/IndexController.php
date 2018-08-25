<?php
namespace app\manage\controller;
use app\manage\model\Apps;
use ez\core\Route;

/**
 * 后台首页
 * 
 * @author lxj
 */
class IndexController extends ManageController {
    
    /**
     * 初始化
     * 
     * @access public
     */
    public function index() {
        /* 应用模块查询 */
        $apps   = Apps::select(['app', 'title', 'manageEntryUrl', 'logo', 'id'], [
            'id'    => explode(',', $this->user['company']['apps']),
            'id'    => explode(',', $this->user['role']['apps']),
            'ORDER' => ['sort' => 'ASC'],
        ]);
        foreach ($apps as $key => $val) {
            if (empty($val['manageEntryUrl'])) {
                $menu   = Menu::get(['app', 'controller', 'action'], [
                    'appId' => $val['id'],
                    'id'    => explode(',', $this->user['role']['menuId']),
                    'ORDER' => ['sort' => 'ASC'],
                ]);
                if (!empty($menu)) {
                    $apps[$key]['manageEntryUrl']   = "{$menu['app']}/{$menu['controller']}/{$menu['action']}";
                }
            }
        }
        
        $this->assign('apps', $apps);
        $this->display();
    }
}

