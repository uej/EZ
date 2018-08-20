<?php
namespace app\manage\controller;
use ez\core\Controller;
use ez\core\Session;

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
        $salt   = md5(mt_rand(0, 999999));
        Session::set('loginSalt', $salt);
        $this->ajaxReturn('获取成功', 1, $salt);
    }
    
    
}
