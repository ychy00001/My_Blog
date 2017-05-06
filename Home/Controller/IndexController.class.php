<?php 
namespace Home\Controller;
use \Home\Model\IndexModel;

/**
 * ========================
 * Description  : 默认控制器
 * Author       : Rain
 * ========================
 */
class IndexController{
	/**
	 * 默认初始化方法
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 * @return   null
	 */
	public function index(){
		$modeObj = new IndexModel();
		$arrs = $modeObj->fetchAll();
		include VIEW_PATH."index.html";
	}
}

 ?>