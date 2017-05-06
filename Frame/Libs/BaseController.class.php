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
	protected function jump($msg,$url,$time=2){
		echo "<h2>$msg</h2>";
		header("refresh:$time;url=$url");
		exit();
	}
}

 ?>