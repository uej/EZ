<?php
namespace app\manage\controller;
use app\manage\model\Company;
use app\manage\model\Apps;

/**
 * 商户控制器
 * 
 * @author lxj
 */
class CompanyController extends ManageController {
    
    /**
     * 商户列表
     * 
     * @access public
     */
    public function index() {
        $company    = new Company();
        $data       = $company->findPage(10);
        $this->assign($data);
        $this->render();
    }
    
    /**
     * 添加商户
     * 
     * @access public
     */
    public function addCompany() {
        if (empty($_POST)) {
            if ($this->user['roleId'] == 1) {
                $this->assign('apps', Apps::select(['id', 'title']));
            } else {
                $this->assign('apps', Apps::select(['id', 'title'], ['id' => $this->user['company']['apps']]));
            }
            $this->display();
        } else {
            $company    = new Company();
            $data   = $this->create();
            $data['createTime'] = time();

            if (empty($data['name'])) {
                $this->error('商户名称不能为空');
            }
            if (empty($data['contact'])) {
                $this->error('商户联系人不能为空');
            }
            if (empty($data['phone'])) {
                $this->error('商户联系电话不能为空');
            }
            if (empty($data['apps'])) {
                $this->error('请选择应用模块');
            }
            $data['createUserId']   = $this->user['id'];
            
            if ($company->insert($data)->errorCode() === '00000') {
                $this->success('添加成功');
            } else {
                $this->error($company->error);
            }
        }
    }
    
    /**
     * 编辑商户
     * 
     * @access public
     */
    public function editCompany() {
        if (empty($_POST)) {
            $id = intval($_GET['id']);
        }
    }
    
    
}

