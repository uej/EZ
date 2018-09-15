<?php
namespace app\manage\model;
use ez\core\Model;

/**
 * 商户模型
 * 
 * @author lxj
 */
class Company extends Model {
    
    /**
     * @var string 表名
     */
    public static $tableName = 'common_company';
    
    
    /**
     * 添加商户
     * 
     * @access public
     */
    public function addCompany($data = []) {
        $data   = $this->create($data);
        $data['createTime'] = time();
        
        
    }
}
