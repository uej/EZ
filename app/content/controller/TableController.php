<?php
namespace app\content\controller;
use app\manage\controller\ManageController;
use app\content\model\Table;
use app\content\model\Field;

/**
 * 模型管理
 * 
 * @author lxj
 */
class TableController extends ManageController {
    
    /**
     * 数据表列表
     * 
     * @access public
     */
    public function table() {
        $table  = new Table();
        $data   = $table->findPage(10);
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
            $this->assign('type', Table::ENGINE);
            $this->display();
        } else {
            $table  = new Table();
            $data   = $table->create();
            $res    = $table->add($this->user['id'], $data);
            if ($res) {
                $this->success('添加成功');
            } else {
                $this->error($table->error);
            }
        }
    }
    
    /**
     * 编辑数据表
     * 
     * @access public
     */
    public function editTable() {
        if (empty($_POST) && $_GET['id']) {
            $id = intval($_GET['id']);
            $data   = Table::get('*', ['id' => $id]);
            $this->assign('data', $data);
            $this->display();
        } else if (!empty($_POST['id'])) {
            $data   = $table->create();
            $res    = $table->edit($this->user['id'], $data);
            if ($res) {
                $this->success('编辑成功');
            } else {
                $this->error($table->error);
            }
        }
    }
    
    /**
     * 字段列表
     * 
     * @access public
     */
    public function field() {
        $id = intval($_GET['id']);
        if (Table::has(['id' => $id])) {
            $data   = Field::select('*', ['tableId' => $id]);
            $this->assign('data', $data);
            $this->display();
        } else {
            $this->error('表不存在');
        }
    }
    
    /**
     * 字段添加
     * 
     * @access public
     */
    public function addField() {
        if (empty($_POST)) {
            $id = intval($_GET['id']);
            if (!Table::has(['id' => $id])) {
                $this->error('表不存在');
            }
            $this->assign('id', $id);
            $this->display();
        } else {
            $field  = new Field();
            $data   = $field->create();
            
        }
    }
    
}
