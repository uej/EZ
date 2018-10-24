<?php
namespace app\manage\controller;
use app\manage\model\User;
use app\manage\model\Role;
use app\manage\model\Menu;
use app\manage\model\Apps;
use app\manage\model\Company;

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
        $key    = trim(filter_input(INPUT_GET, 'key'));
        $companyId  = intval($_GET['companyId']);
        $where  = NULL;
        if (!empty($key)) {
            $where['OR']    = [
                'account'   => $key,
                'name[~]'   => $key,
                'phone'     => $key,
            ];
        }
        if (!empty($companyId)) {
            $where['companyId'] = $companyId;
        }
        
        $user   = new User();
        $data   = $user->findPage(10, $where);
        $this->assign('company', Company::select(['id', 'name']));
        $this->assign($data);
        $this->assign('user', $this->user);
        $this->render();
    }
    
    /**
     * 添加用户
     * 
     * @access public
     */
    public function addUser() {
        if (empty($_POST)) {
            if ($this->user['roleId'] == 1) {
                $this->assign('company', Company::select(['id', 'name']));
                $this->assign('role', Role::select(['id', 'name', 'companyId']));
            } else {
                $this->assign('role', Role::select(['id', 'name', 'companyId'], ['companyId' => [0, $this->user['companyId']]]));
            }
            $this->assign('user', $this->user);
            $this->display();
        } else {
            $user   = new User();
            $data   = $user->create();
            $data['createTime']     = time();
            $data['createUserId']   = $this->user['id'];
            if (empty($data['companyId'])) {
                $data['companyId']  = $this->user['companyId'];
            }
            if ($user->addUser($data)) {
                $this->success('添加成功');
            } else {
                $this->error($user->error);
            }
        }
    }
    
    /**
     * 编辑用户
     * 
     * @access public
     */
    public function editUser() {
        $user   = new User();
        
        if (empty($_POST['id'])) {
            $id = intval($_GET['id']);
            $id < 1 && $this->error('参数错误');
            $data   = $user->get('*', ['id' => $id]);
            $this->assign('data', $data);
            $this->assign('user', $this->user);
            if ($this->user['roleId'] == 1) {
                $this->assign('company', Company::select(['id', 'name']));
                $this->assign('role', Role::select(['id', 'name', 'companyId']));
                $this->assign('nowrole', Role::select(['id', 'name', 'companyId'], ['companyId' => $data['companyId']]));
            } else {
                $this->assign('role', Role::select(['id', 'name', 'companyId'], ['companyId' => [0, $this->user['companyId']]]));
            }
            $this->display();
        } else {
            $user   = new User();
            $data   = $user->create();
            if ($user->editUser($data)) {
                $this->success('添加成功');
            } else {
                $this->error($user->error);
            }
        }
    }
    
    /**
     * 角色列表
     * 
     * @access public
     */
    public function role() {
        $role   = new Role();
        if ($this->user['companyId'] == 1) {
            $data   = $role->findPage(10);
        } else {
            $data   = $role->findPage(10, [
                'companyId' => [$this->user['companyId'], 0],
            ]);
        }
        $this->assign($data);
        $this->render();
    }
    
    /**
     * 添加角色 (非超级管理员仅可以授权自己商户拥有应用下的功能或菜单)
     * 
     * @access public
     */
    public function addRole() {
        if (empty($_POST)) {
            if ($this->user['roleId'] == 1) {
                $menus  = Menu::select(['id', 'title', 'appId']);
                $apps   = Apps::select(['id', 'title']);
                $company    = Company::select(['id', 'name']);
                $this->assign('company', $company);
            } else {
                $menus  = Menu::select(['id', 'title', 'appId'], ['appId' => explode(',', $this->user['role']['apps'])]);
                if ($this->user['companyId'] == 1) {
                    $apps   = Apps::select(['id', 'title']);
                } else {
                    $apps   = Apps::select(['id', 'title'], ['id' => explode(',', $this->user['company']['apps'])]);
                }
            }
            $this->assign('menus', $menus);
            $this->assign('apps', $apps);
            $this->assign('user', $this->user);
            $this->display();
        } else {
            $role   = new Role();
            $data   = $role->create();
            if ($this->user['roleId'] != 1) {
                $data['companyId']  = $this->user['companyId'];
            }
            $data['apps']   = implode(',', $data['apps']);
            $data['menuId'] = implode(',', $data['menuId']);
            $data['createTime']     = time();
            $data['createUserId']   = $this->user['id'];
            
            $res    = $role->insert($data);
            if ($res->errorCode() === '00000') {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        }
    }
    
    /**
     * 编辑角色
     * 
     * @access public
     */
    public function editRole() {
        if (empty($_POST)) {
            $id = intval($_GET['id']);
            if ($id > 0) {
                if ($this->user['roleId'] == 1) {
                    $menus  = Menu::select(['id', 'title', 'appId']);
                    $apps   = Apps::select(['id', 'title']);
                    $company    = Company::select(['id', 'name']);
                    $this->assign('company', $company);
                } else {
                    $menus  = Menu::select(['id', 'title', 'appId'], ['appId' => explode(',', $this->user['role']['apps'])]);
                    $apps   = Apps::select(['id', 'title'], ['id' => explode(',', $this->user['company']['apps'])]);
                }

                $this->assign('user', $this->user);
                $this->assign('data', Role::get('*', ['id' => $id]));
                $this->assign('menus', $menus);
                $this->assign('apps', $apps);
                $this->display();
            }
        } else {
            $role   = new Role();
            $data   = $role->create();
            $data['apps']   = implode(',', $data['apps']);
            $data['menuId'] = implode(',', $data['menuId']);
            $data['modifyUserId']   = $this->user['id'];
            
            $res    = $role->update($data, ['id' => $data['id']]);
            if ($res->errorCode() === '00000') {
                $this->success('编辑成功');
            } else {
                $this->error('编辑失败');
            }
        }
    }
    
}