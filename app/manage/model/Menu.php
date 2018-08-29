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
    
}

