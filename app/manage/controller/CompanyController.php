<?php
namespace app\manage\controller;
use app\manage\model\Company;
use app\manage\model\Apps;
use app\manage\model\CompanyType;

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
            $this->display();
        } else {
            $company    = new Company();
            $data   = $company->create();
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
            $data['createUserId']   = $this->user['id'];
            $data['apps']   = implode(',', $data['apps']);
            
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
            if ($id > 0) {
                $data   = Company::get('*', ['id' => $id]);
                $this->assign('data', $data);
                $this->display();
            }
        } else {
            $company    = new Company();
            $data   = $company->create();
            $id = intval($data['id']);
            
            if ($id <= 0) {
                $this->error('参数错误');
            }
            if (empty($data['name'])) {
                $this->error('商户名称不能为空');
            }
            if (empty($data['contact'])) {
                $this->error('商户联系人不能为空');
            }
            if (empty($data['phone'])) {
                $this->error('商户联系电话不能为空');
            }
            $data['modifyUserId']   = $this->user['id'];
            $data['apps']   = implode(',', $data['apps']);
            
            if ($company->update($data, ['id' => $id])->errorCode() === '00000') {
                $this->success('编辑成功');
            } else {
                $this->error($company->error);
            }
        }
    }
    
    /**
     * 商户类型
     * 
     * @access public
     */
    public function companyType() {
        $companyType    = new CompanyType();
        $data   = $companyType->findPage(10);
        $this->assign($data);
        $this->render();
    }
    
    /**
     * 添加类型
     * 
     * @access public
     */
    public function addCompanyType() {
        if (empty($_POST)) {
            if ($this->user['roleId'] == 1) {
                $this->assign('apps', Apps::select(['id', 'title']));
            } else {
                $this->assign('apps', Apps::select(['id', 'title'], ['id' => $this->user['company']['apps']]));
            }
            $this->display();
            
        } else {
            $companyType    = new CompanyType();
            $data   = $companyType->create();
            if ($data) {
                $data['apps']           = implode(',', $data['apps']);
                $data['createTime']     = time();
                $data['createUserId']   = $this->user['id'];
                $res    = $companyType->insert($data);
                if ($res->errorCode() === '00000') {
                    $this->success('添加成功');
                } else {
                    $this->error($res->errorInfo()[2]);
                }
            } else {
                $this->error($companyType->error);
            }
        }
    }
    
    /**
     * 编辑商户类型
     * 
     * @access public
     */
    public function editCompanyType() {
        if (empty($_POST)) {
            if ($this->user['roleId'] == 1) {
                $this->assign('apps', Apps::select(['id', 'title']));
            } else {
                $this->assign('apps', Apps::select(['id', 'title'], ['id' => $this->user['company']['apps']]));
            }
            $id = intval($_GET['id']);
            if ($id > 0) {
                $this->assign('data', CompanyType::get('*', ['id' => $id]));
                $this->display();
            }
            
        } else {
            $companyType    = new CompanyType();
            $data   = $companyType->create();
            if ($data) {
                $id = intval($data['id']);
                $data['apps']   = implode(',', $data['apps']);
                $res    = $companyType->update($data, ['id' => $id]);
                if ($res->errorCode() === '00000') {
                    $this->success('编辑成功');
                } else {
                    $this->error($companyType->error);
                }
            } else {
                $this->error($companyType->error);
            }
        }
    }
    
    /**
     * 删除商户类型
     * 
     * @access public
     */
    public function delCompanyType() {
        $id = intval($_GET['id']);
        if ($id > 0) {
            if (Company::has(['typeId' => $id])) {
                $this->error('此类型使用中，不能删除');
            }
            
            $res    = CompanyType::delete(['id' => $id]);
            if ($res->errorCode() === '00000') {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('参数错误');
        }
    }
    
}

