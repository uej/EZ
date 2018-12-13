<?php
namespace app\manage\model;
use ez\core\Model;
use ez\core\Ez;
use ez\core\Log;

/**
 * 后台用户模型
 * 
 * @access public
 */
class User extends Model
{
    /**
     * @var string 表名
     */
    public static $tableName = 'manage_user';
    
    /**
     * 登录
     * 
     * @param string $account
     * @param string $password
     * @param array $salt
     * @return string
     * @access public
     */
    public function login($account, $password, $salt)
    {
        $result = [
            'code'  => 0,
            'msg'   => '登录失败',
        ];
        
        $userData   = $this->get('*', ['account' => $account]);
        if (empty($userData)) {
            $result['msg']  = '账号或密码错误';
            return $result;
        }
        if ($userData['status'] != 1) {
            $result['msg']  = '账号状态不正常，请联系管理员';
            return $result;
        }
        
        if (md5(md5($account . $userData['password']) . $salt['value']) == $password) {
            $userData['company']    = Company::get('*', ['id' => $userData['companyId']]);
            $userData['company']['apps']    = CompanyType::get('apps', ['id' => $userData['company']['typeId']]);
            if ($userData['company']['status'] != 1) {
                $result['msg']  = '账号所属商户已停用';
                return $result;
            }
            $userData['role']       = Role::get(['name', 'menuId', 'apps'], ['id' => $userData['roleId']]);
            $result['userData']     = $userData;
            
            $result['code'] = 1;
            $result['msg']  = '登录成功';
            
            $this->update(['loginErrorTimes' => 0], ['id' => $userData['id']]);
        } else {
            $this->update(['loginErrorTimes[+]' => 1], ['id' => $userData['id']]);
            
            if (Ez::config('loginErrorTimes') > 0) {
                if ($userData['loginErrorTimes'] + 1 >= Ez::config('loginErrorTimes')) {
                    $result['msg']  = '密码输入错误！账号已封禁';
                } else {
                    $canError   = Ez::config('loginErrorTimes') - 1 - $userData['loginErrorTimes'];
                    $result['msg']  = "密码输入错误！再错误{$canError}次账号将被封禁";
                }
            } else {
                $result['msg']  = '账号或密码输入错误！';
            }
        }
        return $result;
    }
    
    /**
     * 添加用户
     * 
     * @param array $data 用户数据
     * @return bool 成功返回true，失败返回false
     * @access public
     */
    public function addUser($data = []) {
        if (!$this->checkUserData($data)) {
            return FALSE;
        }
        if (self::checkPwdLevel($data['password']) < 3) {
            $this->error    = '密码过于简单，必须不小于8位且包含字母数字符号';
            return false;
        }
        $data['password']   = sha1(sha1($data['account'] . $data['password']));
        $result = $this->insert($data);
        if ($result->errorCode() === '00000') {
            return $this->id();
        } else {
            $this->error = '添加用户失败';
            Log::addLog('添加应用失败：'.$result->errorInfo[2]);
            return FALSE;
        }
    }
    
    /**
     * 编辑用户
     * 
     * @param array $data 用户数据
     * @return bool 成功返回true，失败返回false
     * @access public
     */
    public function editUser($data = []) {
        if (!$this->checkUserData($data)) {
            return FALSE;
        }
        if (!empty($data['password']) && self::checkPwdLevel($data['password']) < 3) {
            $this->error    = '密码过于简单，必须不小于8位且包含字母数字符号';
            return false;
        } else if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password']   = sha1(sha1($data['account'] . $data['password']));
        }
        $result = $this->update($data, ['id' => $data['id']]);
        if ($result->errorCode() === '00000') {
            return true;
        } else {
            $this->error = '编辑用户失败';
            Log::addLog('编辑用户失败：'.$result->errorInfo[2]);
            return FALSE;
        }
    }
    
    /**
     * 数据校验
     * 
     * @param array $data 校验的数据
     * @return bool 校验结果
     */
    public function checkUserData($data) {
        if (empty($data['name'])) {
            $this->error    = '请填写用户姓名';
            return false;
        }
        if (empty($data['account'])) {
            $this->error    = '请填写登录账号';
            return false;
        }
        if (empty($data['companyId']) || empty($data['roleId'])) {
            $this->error    = '请选择用户所属商户和角色';
            return false;
        }
        $roledata   = Role::get('*', ['id' => $data['roleId']]);
        if ($roledata['companyId'] !== '0' && $roledata['companyId'] != $data['companyId']) {
            $this->error    = '所选角色和商户不对应';
            return false;
        }
        
        return TRUE;
    }
    
    /**
     * 检查密码强度
     * 
     * @access public
     */
    public static function checkPwdLevel($pwd = '') {
        if (strlen($pwd) < 8) {
            return 1;
        }
        if (is_numeric($pwd)) {
            return 1;
        }

        $level = 0;
        if (preg_match('/[a-z]/', $pwd)) $level++;
        if (preg_match('/[A-Z]/', $pwd)) $level++;
        if (preg_match('/[0-9]/', $pwd)) $level++;
        if (preg_match('/[^a-zA-Z0-9]/', $pwd)) $level++;
        return $level;
    }
    
}

