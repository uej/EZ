<?php
namespace app\manage\model;
use ez\core\Model;

/**
 * 菜单功能模型
 * 
 * @author lxj
 */
class Menu extends Model {
    
    /**
     * @var string 表名
     */
    public static $tableName = 'manage_menu';
    
    /**
     * @var array 菜单功能类型
     */
    public $typeId  = [
        1   => '顶部菜单',
        2   => '单项数据操作',
        3   => '菜单内按钮',
        4   => '自定义',
    ];
    
    /**
     * @var array 菜单功能类型id
     */
    public $canChooseTypeId = [1,2,3,4];
    
    /**
     * @var array 请求方式
     */
    public $requestType = [
        0   => '无',
        1   => '当前页跳转',
        2   => '新开iframe',
        3   => 'ajax请求',
    ];
    
    
    /**
     * 添加功能菜单
     * 
     * @access public
     */
    public function addMenu($data = []) {
        $data   = $this->create($data);
        $data['createTime'] = time();
        
        if (!$this->checkField($data)) {
            return false;
        }
        
        $result = $this->insert($data);
        if ($result->errorCode() === '00000') {
            return $this->id();
        } else {
            $this->error = '添加菜单失败';
            Log::addLog('添加菜单失败：'.$result->errorInfo[2]);
            return false;
        }
    }
    
    /**
     * 菜单编辑
     * 
     * @access public
     */
    public function editMenu($data = []) {
        $data   = $this->create($data);
        $data['createTime'] = time();
        
        if (!$this->checkField($data)) {
            return false;
        }
        
        $result = $this->update($data, ['id' => $data['id']]);
        if ($result->errorCode() === '00000') {
            return true;
        } else {
            $this->error = '编辑菜单失败';
            Log::addLog('编辑菜单失败：'.$result->errorInfo[2]);
            return false;
        }
    }
    
    /**
     * 数据验证
     * 
     * @access public
     */
    public function checkField($data) {
        if (!in_array($data['typeId'], $this->canChooseTypeId)) {
            $this->error    = '未定义的菜单类型';
            return false;
        }
        if (empty($data['appId'])) {
            $this->error    = '请选择所属应用';
            return false;
        }
        if (empty($data['title'])) {
            $this->error    = '请填写菜单名称';
            return false;
        }
        if (empty($data['app']) || empty($data['controller']) || empty($data['action'])) {
            $this->error    = '菜单访问路由不完整';
            return false;
        }
        if (!is_numeric($data['parentId'])) {
            $this->error    = '请选择上级菜单';
            return false;
        }
        
        return true;
    }
    
}

