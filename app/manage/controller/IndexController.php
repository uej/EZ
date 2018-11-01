<?php
namespace app\manage\controller;
use app\manage\model\Apps;
use app\manage\model\Menu;
use app\manage\model\User;

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
            $apps   = Apps::select(['app', 'title', 'manageEntryUrl', 'logo', 'id', 'logoColor'], ['status' => 1]);
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
            $apps   = Apps::select(['app', 'title', 'manageEntryUrl', 'logo', 'id', 'logoColor'], [
                'id'    => explode(',', $this->user['company']['apps']),
                'id'    => explode(',', $this->user['role']['apps']),
                'ORDER' => ['sort' => 'ASC'],
            ]);
            foreach ($apps as $key => $val) {
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
        
        $this->assign('apps', $apps);
        $this->assign('user', $this->user);
        $this->display();
    }
    
    /**
     * 修改密码
     * 
     * @access public
     */
    public function changepwd() {
        if (empty($_POST)) {
            $this->display();
        } else {
            $oldPassword    = $_POST['oldPassword'];
            $password       = $_POST['password'];
            $passwordAgain  = $_POST['passwordAgain'];
            $signOldPwd     = sha1(sha1($this->user['account'] . $oldPassword));
                    
            if ($signOldPwd != User::get('password', ['id' => $this->user['id']])) {
                $this->ajaxReturn('旧密码输入错误', 0);
            }
            if ($password !== $passwordAgain) {
                $this->ajaxReturn('两次密码输入不一致', 0);
            }
            $newSignPwd = sha1(sha1($this->user['account'] . $password));
            $res    = User::update(['password' => $newSignPwd], ['id' => $this->user['id']]);
            if ($res->errorCode() === '00000') {
                $this->ajaxReturn('修改成功');
            } else {
                $this->ajaxReturn('修改失败', 0);
            }
        }
    }
    
}

