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
            if ($company->addCompany()) {
                $this->success('添加成功');
            } else {
                $this->error($apps->error);
            }
        }
    }
    
    
    
}

