<?php
namespace app\manage\controller;
use app\manage\model\Apps;

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
        if ($this->user['roleId'] == 1) {
            $apps   = Apps::select(['app', 'title', 'manageEntryUrl', 'logo', 'id'], ['status' => 1]);
            foreach ($apps as $key => $val) {
                if (empty($val['manageEntryUrl'])) {
                    $menu   = Menu::get(['app', 'controller', 'action'], [
                        'appId' => $val['id'],
                        'typeId'=> 1,
                        'ORDER' => ['sort' => 'ASC'],
                    ]);
                    if (!empty($menu)) {
                        $apps[$key]['manageEntryUrl']   = "{$menu['app']}/{$menu['controller']}/{$menu['action']}";
                    }
                }
            }
        } else {
            $apps   = Apps::select(['app', 'title', 'manageEntryUrl', 'logo', 'id'], [
                'id'    => explode(',', $this->user['company']['apps']),
                'id'    => explode(',', $this->user['role']['apps']),
                'ORDER' => ['sort' => 'ASC'],
            ]);
            foreach ($apps as $key => $val) {
                if (empty($val['manageEntryUrl'])) {
                    $menu   = Menu::get(['app', 'controller', 'action'], [
                        'appId' => $val['id'],
                        'typeId'=> 1,
                        'id'    => explode(',', $this->user['role']['menuId']),
                        'ORDER' => ['sort' => 'ASC'],
                    ]);
                    if (!empty($menu)) {
                        $apps[$key]['manageEntryUrl']   = "{$menu['app']}/{$menu['controller']}/{$menu['action']}";
                    }
                }
            }
        }
        
        $this->assign('apps', $apps);
        $this->display();
    }
}

