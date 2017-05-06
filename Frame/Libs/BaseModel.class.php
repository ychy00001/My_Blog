<?php 
namespace Frame\Libs;
use \Frame\Vendor\PDOWrapper;

/**
 * ========================
 * Description  : 模型基类
 * Author       : Rain
 * ========================
 */
abstract class BaseModel{
	//受保护的pdo对象
	protected $pdo = null;

	protected static $modelObjArr = array();

	/**
	 * 基类构造函数 创建一个PDO类 供子类使用
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 */
	private function __construct(){
		$this->pdo = new PDOWrapper();
	}

	/**
	 * 获取当前静态绑定类的实例
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   [Object]     [返回单例静态绑定类]
	 */
	public static function getInstance(){
		$modelClassName = get_called_class();
		if(!isset(self::$modelObjArr[$modelClassName])){
			self::$modelObjArr[$modelClassName] = new $modelClassName();
		}
		return self::$modelObjArr[$modelClassName];
	}


}

 ?>