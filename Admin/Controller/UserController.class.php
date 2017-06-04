<?php 
/**
 * ========================
 * Description  : 后台用户控制器类
 * Author       : Rain
 * ========================
 */

namespace Admin\Controller;

use \Frame\Libs\BaseController;
use \Admin\Model\UserModel;
use \Frame\Vendor\Captcha;

final class UserController extends BaseController{

	/**
	 * 后台默认用户管理页面显示方法
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 */
	public function index(){
		$this->denyAccess();
		//获取所有用户信息
		$modelObj = UserModel::getInstance();
		$users = $modelObj->fetchAll();
		$this->smarty->assign("users",$users);
		$this->smarty->display("index.html");
	}

	/**
	 * 删除后台用户信息方法
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 */
	public function delete(){
		$this->denyAccess();
		$id = $_GET['id'];
		$modelObj = UserModel::getInstance();
		if($modelObj->delete($id)){
			$this->jump("id={$id}的用户删除成功","?c=User&a=index",1);
		}else{
			$this->jump("id={$id}的用户删除失败","?c=User&a=index",1);
		}

	}

	/**
	 * 添加后台用户 跳转至添加页面
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 */
	public function add(){
		$this->denyAccess();
		$this->smarty->display("Add.html");
	}

	/**
	 * 插入后台用户数据 请求处理方法
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 */
	public function insert(){
		$this->denyAccess();
		$data['username'] = $_POST['username'];
		//判断用户名是否存在
		$records = UserModel::getInstance()->rowCount("username="."\"".$_POST['username']."\"");
		if($records){
			$this->jump("用户名{$_POST['username']}已经存在","?c=User&a=add",1);
		}

		if($_POST['password']!=$_POST['confirmpwd']){
			$this->jump("两次密码不一致","?c=User&a=add",2);
		}
		$data['password'] = md5($_POST['password']);
		$data['name'] = $_POST['name'];
		$data['tel'] = $_POST['tel'];
		$data['status'] = $_POST['status'];
		$data['role'] = $_POST['role'];
		$data['addate'] = time();
		//写入数据
		UserModel::getInstance()->insert($data);
		$this->jump("{$_POST['username']}注册成功","?c=User",1);
	}

	/**
	 * 后台编辑用户数据请求
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 */
	public function edit(){
		$this->denyAccess();
		$id = $_GET['id'];
		$user = UserModel::getInstance()->fetchOne("id='$id'");
		$this->smarty->assign("user",$user);
		$this->smarty->display("Edit.html");
	}

	/**
	 * 后台用户数据更新方法
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 */
	public function update(){
		$this->denyAccess();
		$id = $_POST['id'];
		if($_POST['password'] == $_POST['confirmpwd']){
			if(!empty($_POST['password'])){
				$data['password'] = md5($_POST['password']);
			}
		}
		$data['name'] = $_POST['name'];
		$data['tel'] = $_POST['tel'];
		$data['status'] = $_POST['status'];
		$data['role'] = $_POST['role'];
		UserModel::getInstance()->update($data,$id);
		$this->jump("id={$_POST['id']}用户修改成功","?c=User");
	}

	/**
	 * 后台管理用户登陆方法
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function login(){
		//调用登陆的视图文件
		$this->smarty->display("login.html");
	}

	/**
	 * 点击登陆后检测可否登陆
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function loginCheck(){
		//获取表单提交值
		$username = $_POST['username'];
		$password = md5($_POST['password']);

		//TODO 更换登陆界面 取消验证码验证
		// $verify = $_POST['verify'];
		//判断验证码
		// if(strtolower($verify) != $_SESSION['captcha']){
		// 	$this->jump("验证码输入错误","?c=User&a=login");
		// }
		
		$data['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['last_login_time'] = time();

		//判断验证码  用户名名
		$user = UserModel::getInstance()->fetchOne("username='$username' and password='$password'");
		if(empty($user)){
			$this->jump("用户名密码不正确!","?c=User&a=login");
		}
		//更新用户资料信息
		UserModel::getInstance()->loginUpdate($data,$user['id']);
		//用户信息保存Session
		$_SESSION['uid'] = $user['id'];
		$_SESSION['username'] = $username;
		//跳转后台管理首页
		$this->jump("登陆成功","?c=Index");
	}


	/**
	 * 获取验证码方法
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function captcha(){
		$c = new Captcha();
		$_SESSION['captcha'] = $c->getCode();
	}

	/**
	 * 退出登录
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function logout(){
		unset($_SESSION['uid']);
		unset($_SESSION['username']);
		session_destroy();//删除session文件
		//跳转到登陆
		$this->jump("用户退出成功","?c=User&a=login");
	}

}
