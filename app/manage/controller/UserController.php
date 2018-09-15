<?php
namespace app\manage\controller;
use app\manage\model\User;

/**
 * 用户管理控制器
 * 
 * @author lxj
 */
class UserController extends ManageController {
    
    /**
     * 用户列表
     * 
     * @access public
     */
    public function index() {
        $user   = new User();
        $data   = $user->findPage(10);
        $this->assign($data);
        $this->render();
    }
    
}
