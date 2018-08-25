<?php
namespace app\manage\model;
use ez\core\Model;
use ez\core\Ez;

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
    public static $tableName = 'common_user';
    
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
            $result['code'] = 1;
            $result['msg']  = '登录成功';
            
            $userData['company']    = Company::get('*', ['id' => $userData['companyId']]);
            $userData['role']       = Role::get(['name', 'menuId', 'apps'], ['id' => $userData['roleId']]);
            $result['userData']     = $userData;
            
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
}

