<?php 
namespace Frame;
/**
 * ========================
 * Description  : 框架初始化类
 * Author       : Rain
 * ========================
 */

final class Frame{
	/**
	 * 框架主要执行方法 index.php请求时调用
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 */
	public static function run(){
		self::initCharset();//网页字符集
		self::initConfig();//初始化配置文件
		self::initRoute();//初始化url连接参数获取
		self::initConst();//初始化常量
		self::initAutoLoad();//类自动加载
		self::initDispatch();//请求分发
	}

	/**
	 * 设置网页字符集
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 */
	private static function initCharset(){
		header("Content-type:text/html;charset=utf-8");
		session_start();
	}

	/**
	 * 初始化配置文件
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 */
	private static function initConfig(){
		$GLOBALS['config'] = require_once(APP_PATH."Conf".DS."Config.php");
	}

	/**
	 * 初始化路由参数  从url中获取要执行的方法
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 */
	private static function initRoute(){
		$p = $GLOBALS['config']['default_platform'];
		$c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['default_controller'];
		$a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['default_action'];
		define("PLAT",$p);
		define("CONTROLLER",$c);
		define("ACTION",$a);
	}

	/**
	 * 初始化常量
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 */
	private static function initConst(){
		//定义当前视图路径
		define("VIEW_PATH",APP_PATH."View".DS.CONTROLLER.DS);
		//定义Frame框架的路径
		define("FRAME_PATH",ROOT_PATH."Frame".DS);
	}

	/**
	 * 类的自动加载
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 */
	private static function initAutoLoad(){
		spl_autoload_register(function ($className){
			$filename = ROOT_PATH.str_replace("\\",DS,$className).".class.php";
			// echo $filename."<br>";
			if(file_exists($filename)) require_once($filename);
		});
	}

	/**
	 * 请求分发 创建控制器对象 调用控制器对象的方法
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 */
	private static function initDispatch(){
		$c = "\\".PLAT."\\"."Controller"."\\".CONTROLLER."Controller";
		$controllerObj = new $c();
		$a = ACTION;
		$controllerObj -> $a();
	}
}

