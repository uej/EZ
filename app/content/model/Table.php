<?php
namespace app\content\model;
use ez\core\Model;

/**
 * 数据表表
 * 
 * @author lxj
 */
class Table extends Model {
    
    /**
     * @var array 表引擎
     */
    const ENGINE   = [
        'InnoDB',
        'MyISAM',
    ];
    
    /**
     * @var string 表名
     */
    public static $tableName   = 'content_table';
    
    
    /**
     * 添加内容表
     * 
     * @param integer $userId 用户id
     * @param mixed $data 数据
     * @access public
     * @return bool 成功true 失败false
     */
    public function add($userId, $data = NULL) {
        if (empty($data)) {
            $data   = $this->create();
        }
        if (empty($data['name']) || empty($data['title']) || empty($data['type'])) {
            $this->error('数据填写不完整');
        }
        $data['createTime']     = time();
        $data['createUserId']   = $userId;
        
        $this->pdo()->beginTransaction();
        $res    = $this->insert($data);
        if ($res->errorCode() !== '00000' || $this->id() < 0) {
            $this->error    = '添加数据表记录失败';
            $this->pdo()->rollBack();
            return FALSE;
        }
        
        $result = $this->createTable($data['name'], $data['title'], 'id', $data['type']);
        if (!$result) {
            $this->pdo()->rollBack();
            return FALSE;
        } else if (is_object($result)) {
            if ($result->errorCode() === '00000') {
                return TRUE;
            } else {
                $this->error    = '创建数据表失败';
                $this->pdo()->rollBack();
                return FALSE;
            }
        }
    }
    
    /**
     * 编辑表
     * 
     * @param integer $userId 用户id
     * @param mixed $data 数据
     * @access public
     * @return bool 成功true 失败false
     */
    public function edit($userId, $data = NULL) {
        if (empty($data)) {
            $data   = $this->create();
        }
        if (empty($data['name']) || empty($data['title']) || empty($data['type']) || empty($data['id'])) {
            $this->error('数据填写不完整');
        }
        if (!$this->has(['id' => $data['id']])) {
            $this->error('数据表不存在');
        }
        $data['updateTime']     = time();
        $data['updateUserId']   = $userId;
        
        $oldData    = $this->get('*', ['id' => $data['id']]);
        $this->pdo()->beginTransaction();
        $res    = $this->update($data, ['id' => $data['id']]);
        if ($res->errorCode() !== '00000') {
            $this->error    = '添加数据表记录失败';
            $this->pdo()->rollBack();
            return FALSE;
        }
        
        if ($data['name'] != $oldData['name']) {
            $res    = $this->renameTable($oldData['name'], $data['name']);
            if ($res == FALSE) {
                $this->pdo()->rollBack();
                return FALSE;
            } else if ($res->errorCode() !== '00000') {
                $this->error = '修改表名失败';
                $this->pdo()->rollBack();
                return FALSE;
            }
        }
        if ($data['title'] != $oldData['title'] || $data['type'] != $oldData['type']) {
            if ($data['type'] != $oldData['type']) {
                $res    = $this->editTable($data['name'], $data['title'], $data['type']);
            } else {
                $res    = $this->editTable($data['name'], $data['title']);
            }
            
            if ($res == FALSE) {
                $this->pdo()->rollBack();
                return FALSE;
            } else if (is_object($res)) {
                if ($res->errorCode() === '00000') {
                    return TRUE;
                } else {
                    $this->error = '修改表信息失败';
                    $this->pdo()->rollBack();
                    return FALSE;
                }
            }  
        }
    }
    
    /**
     * 创建表
     * 
     * @param string $table 表名
     * @param string $title 表注释
     * @param string $primaryKey 主键
     * @param string $engine 引擎
     * @access private
     * @return mixed 不和规则返回false，否则返回PDOStatement
     */
    private function createTable($table, $title = '', $primaryKey="id", $engine = "InnoDB") {
        if (!$this->checkString($table) || !$this->checkString($primaryKey) || !$this->checkString($engine)) {
            $this->error    = '数据表命名不合规范，仅限使用数字字母及下划线';
            $this->pdo()->rollBack();
            return FALSE;
        }
        
        $sql = "CREATE TABLE `{$this->tablePrefix}{$table}` ( "
        . "`$primaryKey` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`$primaryKey`)) "
        . "ENGINE = $engine COMMENT = :title";
		return $this->query($sql, [':title' => $title]);
    }
    
    /**
     * 编辑表信息
     * 
     * @param string $table 表名
     * @param string $title 表注释
     * @param string $engine 引擎
     * @access private
     * @return bool Description
     */
    private function editTable($table, $title = '', $engine = '') {
        if (!$this->checkString($engine)) {
            $this->error    = '数据表命名不合规范，仅限使用数字字母及下划线';
            $this->pdo()->rollBack();
            return FALSE;
        }
        
        $sql = "ALTER TABLE `{$this->tablePrefix}{$table}` COMMENT = :title";
        if (!empty($engine)) {
            $sql .= " ENGINE = $engine";
        }
		return $this->query($sql, [':title' => $title]);
    }
    
    /**
     * 修改表名
     * 
     * @param string $oldTableName 旧表名
     * @param string $newTableName 新表名
     * @access private
     * @return mixed 不和规则返回false，否则返回PDOStatement
     */
    private function renameTable($oldTableName, $newTableName) {
        if (!$this->checkString($newTableName)) {
            $this->error    = '数据表命名不合规范，仅限使用数字字母及下划线';
            $this->pdo()->rollBack();
            return FALSE;
        }
        
        $sql    = "RENAME TABLE `{$this->tablePrefix}{$oldTableName}` TO `{$this->tablePrefix}{$newTableName}`";
        return $this->query($sql);
    }
    
    /**
     * 检查字符串是否符合数据表命名规范
     * 
     * @param type $str 待检查字符串
     * @access public
     * @return bool 符合true 反之false
     */
    public static function checkString($str) {
        if (preg_match('/^[0-9a-zA-Z_]/', $str)) {
            return FALSE;
        }
        return true;
    }
    
}
