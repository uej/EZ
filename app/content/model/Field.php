<?php
namespace app\content\model;
use ez\core\Model;
use plugin\form\Form;

/**
 * 字段表
 * 
 * @author lxj
 */
class Field extends Model {
    
    /**
     * @var array 支持的字段类型
     */
    const FIELD_TYPE = [
        'INT',
        'TINYINT',
        'SMALLINT',
        'MEDIUMINT',
        'BIGINT',
        'DECIMAL',
        'FLOAT',
        'DOUBLE',
        'DATE',
        'DATETIME',
        'TIMESTAMP',
        'TIME',
        'YEAR',
        'CHAR',
        'VARCHAR',
        'TEXT',
        'MEDIUMTEXT',
    ];
    
    /**
     * @var string 表名
     */
    public static $tableName   = 'content_fields';
    
    
    /**
     * 添加字段
     * 
     * @param type $data
     */
    public function addField($data = NULL) {
        if (empty($data)) {
            $data   = $this->create();
        }
        
    }
    
    /**
     * 检查字段数据
     * 
     * @param array $data 待检查数据
     * @access public
     */
    public function checkField($data) {
        if (empty($data['tableId'])) {
            $this->error    = '缺少tableId';
            return FALSE;
        }
        if (empty($data['fieldTitle'])) {
            $this->error    = '字段标题必填';
            return FALSE;
        }
        if (!Table::checkString($data['fieldName'])) {
            $this->error    = '字段名只能包含字母、数字和下划线';
            return FALSE;
        }
        if (in_array($data['fieldType'], self::FIELD_TYPE)) {
            $this->error    = '字段类型未配置';
            return FALSE;
        }
        if (empty($data['fieldSize'])) {
            $this->error    = '字段长度不能为空';
            return FALSE;
        }
        if (!empty($data['fieldInput']) && Form::$abc()) {
            $this->error    = '字段输入类型未配置';
            return FALSE;
        }
    }
    
}
