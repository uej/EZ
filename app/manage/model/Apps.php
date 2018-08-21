<?php
namespace app\manage\model;
use ez\core\Model;
use ez\core\Log;

/**
 * app模型
 * 
 * @author lxj
 */
class Apps extends Model
{
    /**
     * @var string 表名
     */
    public static $tableName = 'common_apps';
    
    
    /**
     * 创建数据
     * 
     * @access public
     */
    public function addApp($data = []) {
        $data   = $this->create($data);
        $data['createTime'] = time();
        
        if (!preg_match('/^[a-z]{1}[a-z0-9]*$/', $data['app'])) {
            $this->error    = '应用标识不正确，仅能包含小写字母及数字且小写字母开头';
            return false;
        }
        if (empty($data['title'])) {
            $this->error    = '应用标题不能为空';
            return false;
        }
        if (empty($data['logo'])) {
            $this->error    = '应用图标不能为空';
            return false;
        }
        
        $result = $this->insert($data);
        if ($result->errorCode() === '00000') {
            return $this->id();
        } else {
            $this->error = '添加应用失败';
            Log::addLog('添加应用失败：'.$result->errorInfo[2]);
            return false;
        }
    }
    
    /**
     * 编辑应用
     * 
     * @access public
     */
    public function editApp($data = []) {
        $data   = $this->create($data);
        if (!preg_match('/^[a-z]{1}[a-z0-9]*$/', $data['app'])) {
            $this->error    = '应用标识不正确，仅能包含小写字母及数字且小写字母开头';
            return false;
        }
        if (empty($data['title'])) {
            $this->error    = '应用标题不能为空';
            return false;
        }
        if (empty($data['logo'])) {
            $this->error    = '应用图标不能为空';
            return false;
        }
        
        $result = $this->update($data, ['id' => $data['id']]);
        if ($result->errorCode() === '00000') {
            return true;
        } else {
            $this->error = '编辑应用失败';
            Log::addLog('编辑应用失败：'.$result->errorInfo[2]);
            return false;
        }
    }
    
}


