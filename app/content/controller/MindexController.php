<?php
namespace app\content\controller;
use app\manage\controller\ManageController;
use app\content\model\Table;

/**
 * 模型管理
 * 
 * @author lxj
 */
class ModelController extends ManageController {
    
    /**
     * 数据表列表
     * 
     * @access public
     */
    public function index() {
        $table  = new Table();
        $data   = $table->findPage(10, $where);
        $this->assign($data);
        $this->render();
    }
    
    /**
     * 新增数据表
     * 
     * @access public
     */
    public function addTable() {
        if (empty($_POST)) {
            $this->display();
        } else {
            
        }
    }
    
}
