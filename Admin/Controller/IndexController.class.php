<?php 
namespace Admin\Controller;
use \Admin\Model\IndexModel;
use \Frame\Libs\BaseController;
/**
 * ========================
 * Description  : 默认控制器
 * Author       : Rain
 * ========================
 */

class IndexController extends BaseController{
	/**
	 * 首页默认显示方法
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 * @return   null
	 */
	public function index(){
		$this->denyAccess();
		$this->smarty->display("index.html");
	}

	/**
	 * 框架顶部页面显示内容
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   null
	 */
	public function top(){
		$this->denyAccess();
		$this->smarty->display("top.html");
	}

	/**
	 * 框架左边页面显示内容
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   null
	 */
	public function left(){
		$this->denyAccess();
		$this->smarty->display("left.html");
	}

	/**
	 * 框架主要页面显示内容
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   null
	 */
	public function main(){
		$this->denyAccess();
		$this->smarty->display("main.html");
	}

	/**
	 * 框架中心页面显示内容
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   null
	 */
	public function center(){
		$this->denyAccess();
		$this->smarty->display("center.html");
	}

}

 ?>