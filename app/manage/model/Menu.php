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
    public static $tableName = 'common_menu';
    
    /**
     * @var array 菜单功能类型
     */
    public $typeId  = [
        1   => '顶部菜单',
        2   => '单项数据操作',
        3   => '菜单内按钮',
    ];
    
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
        
        if (!in_array($data['typeId'], $this->typeId)) {
            $this->error    = '菜单类型不正确';
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
        
        $result = $this->insert($data);
        if ($result->errorCode() === '00000') {
            return $this->id();
        } else {
            $this->error = '添加菜单失败';
            Log::addLog('添加菜单失败：'.$result->errorInfo[2]);
            return false;
        }
    }
    
}

