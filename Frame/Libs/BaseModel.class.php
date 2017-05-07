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

	/*************数据库操作*****************/

	/**
	 * 获取一行模型数据
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @param    [integer]     $id [模型编号]
	 * @return   [array]         [模型数据关联数组]
	 */
	public function fetchOne($where="2>1"){
		$sql = "SELECT * FROM {$this->table} where {$where} LIMIT 1";
		return $this->pdo->fetchOne($sql);
	}

	/**
	 * 获取所有模型数据
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   [Array]     [返回所有用户信息]
	 */
	public function fetchAll(){
		$sql = "SELECT * FROM {$this->table} LIMIT 15";
		return $this->pdo->fetchAll($sql);
	}

	/**
	 * 删除模型数据
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @param    [integer]     $id [用户编号]
	 * @return   [boolean]         [是否删除成功]
	 */
	public function delete($id){
		$sql = "DELETE FROM {$this->table} WHERE id = {$id}";
		return $this->pdo->exec($sql);
	}

	/**
	 * 插入模型数据
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @param    [Array]     $data [要插入的数据集合]
	 * @return   [boolean]         [是否删除成功]
	 */
	public function insert($data){
		$fields = "";
		$values = "";
		foreach ($data as $key => $value) {
			$fields .= "$key,";
			$values .= "'$value',";
		}
		$fields = rtrim($fields,",");
		$values = rtrim($values,",");
		//构建插入sql语句
		$sql = "INSERT INTO {$this->table}($fields) VALUES($values) ";
		return $this->pdo->exec($sql);
	}

	/**
	 * 获取行数
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @param    [String]     $where [查询条件]
	 * @return   [integer]            [行数]
	 */
	public function rowCount($where){
		$sql = "SELECT * FROM {$this->table} WHERE $where";
		return $this->pdo->rowCount($sql);
	}

	/**
	 * 更新模型数据
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @param    [array]     $data [更新字段集合]
	 * @param    [integer]     $id   [更新条目编号]
	 * @return   [boolean]           [更新成功/失败]
	 */
	public function update($data,$id){
		$str = "";
		foreach ($data as $key => $value) {
			$str .= "{$key}='$value',";
		}
		$str = rtrim($str,",");

		$sql = "UPDATE {$this->table} set {$str} WHERE id={$id}";
		return $this->pdo->exec($sql);
	}

}

 ?>