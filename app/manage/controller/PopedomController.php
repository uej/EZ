<?php
namespace app\manage\controller;
use ez\core\Controller;
use ez\core\Session;
use ez\core\Ez;
use ez\driver\VerifyCode;

/**
 * 登录控制器
 * 
 * @author lxj
 */
class PopedomController extends Controller
{
    /**
	 * 登陆跳转
	 *
	 * @access public
	 */
	public function index()
    {
		$this->redirect('login');
	}
    
    /**
     * 登录
     * 
     * @access public
     */
    public function login()
    {
        $this->display();
    }
    
    /**
     * 登录临时盐
     * 
     * @access public
     */
    public function salt()
    {
        /* 检查验证码 */
        if (Ez::config('loginVerifyCode')) {
            $verify = new VerifyCode();
            if (!$verify->check(filter_input(INPUT_POST, 'VerifyCode'), 'qcode')) {
                $this->ajaxReturn('验证码不正确', 0);
            }
        }
        
        $salt = [
            'value'     => md5(mt_rand(0, 999999)),
            'createTime'=> time(),
        ];
        Session::set('loginSalt', $salt);
        $this->ajaxReturn('获取成功', 1, $salt['value']);
    }
    
    /**
     * 验证码
     * 
     * @access public
     */
    public function verifyCode()
    {
        $verify = new VerifyCode(['imageH' => 55, 'imageW' => 200, 'useZh' => 0, 'useCurve' => 0]);
        $verify->entry('qcode');
    }
    
    /**
     * 登录判断
     * 
     * @access public
     */
    public function isLogin()
    {
        $account    = trim($_POST['account']);
        $password   = trim($_POST['password']);
        
        if (!empty($account) && !empty($password)) {
            $user   = new \app\manage\model\User();
            $res    = $user->login($account, $password, Session::get('loginSalt'));
            Session::set('loginSalt', NULL);
            if ($res['code'] == 1) {
                Session::set('user', $res['userData']);
                $this->ajaxReturn(\ez\core\Route::createUrl('index/index'), 1);
            } else {
                $this->ajaxReturn($res['msg'], 0);
            }
        } else {
            $this->ajaxReturn('参数错误', 0);
        }
    }
    
    
}
