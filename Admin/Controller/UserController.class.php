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

final class UserController extends BaseController{

	/**
	 * 后台默认用户管理页面显示方法
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   null
	 */
	public function index(){
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
	 * @return  null
	 */
	public function delete(){
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
		$this->smarty->display("Add.html");
	}

	/**
	 * 插入后台用户数据 请求处理方法
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   null
	 */
	public function insert(){
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
	 * @return   [type]     [description]
	 */
	public function edit(){
		$id = $_GET['id'];
		$user = UserModel::getInstance()->fetchOne($id);
		$this->smarty->assign("user",$user);
		$this->smarty->display("Edit.html");
	}

	/**
	 * 后台用户数据更新方法
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   null
	 */
	public function update(){
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
}
 ?>
