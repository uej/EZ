<?php
namespace app\manage\controller;
use app\manage\model\Company;

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
        $data       = $apps->findPage(10);
        $this->display($data);
    }
    
    /**
     * 添加商户
     * 
     * @access public
     */
    public function addCompany() {
        if (empty($_POST)) {
            $this->display();
        } else {
            
        }
    }
    
}

