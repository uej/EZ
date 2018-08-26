<?php
namespace app\manage\controller;
use app\manage\model\Apps;

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
        $apps   = new Apps();
        $data   = $apps->findPage(10);
        $this->display($data);
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
    
}
