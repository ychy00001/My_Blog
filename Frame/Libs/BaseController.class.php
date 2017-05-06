<?php 
namespace Frame\Libs;
use \Frame\Vendor\Smarty;

abstract class BaseController{
	//定义Smarty对象属性
	protected $smarty = NULL;

	/**
	 * 构造函数 调用初始化方法
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 */
	public function __construct(){
		$this->initSmarty();
	}

	/**
	 * 初始化Smarty 配置Smarty的基本属性
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   null
	 */
	protected function initSmarty(){
		$smarty = new Smarty();

		//设置左右边界
		$smarty->left_delimiter = "<{";
		$smarty->right_delimiter = "}>";

		//Smarty配置 模板路径 和 编译临时目录
		$smarty->setTemplateDir(VIEW_PATH);
		$smarty->setCompileDir(sys_get_temp_dir());
		
		//赋值
		$this->smarty = $smarty;
	}

	/**
	 * 跳转URL方法 
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @param    [String]     $msg  [提示信息]
	 * @param    [String]     $url  [跳转连接]
	 * @param    integer    $time [等待秒数]
	 * @return   null
	 */
	protected function jump($msg,$url,$time=3){
		$this->smarty->assign(array(
			'message' => $msg,
			'time' => $time,
			'url' => $url,
			));
		$this->smarty->display("../Public/jump.html");
		exit();
	}

	/**
	 * 拒绝访问的方法
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @return   null
	 */
	protected function denyAccess(){
		if(!isset($_SESSION['username'])){
			//跳转至登陆界面
			$this->jump("请登陆!","?c=User&a=login");
		}
	}
}

 ?>