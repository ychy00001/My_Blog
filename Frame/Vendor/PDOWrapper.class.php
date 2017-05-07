<?php 
/**
 * ========================
 * Description  : POD封装类
 * Author       : Rain
 * ========================
 */

namespace Frame\Vendor;
use \PDO;
use \PDOException;

final class PDOWrapper{
	//数据库配置信息
	private $db_type;
	private $db_host;
	private $db_port;
	private $db_user;
	private $db_pass;
	private $db_name;
	private $charset;
	private $pdo = NULL;

	/**
	 * 构造函数 初始化数据库连接参数
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 */
	public function __construct(){
		$this->db_type = $GLOBALS['config']['db_type'];
		$this->db_host = $GLOBALS['config']['db_host'];
		$this->db_port = $GLOBALS['config']['db_port'];
		$this->db_user = $GLOBALS['config']['db_user'];
		$this->db_pass = $GLOBALS['config']['db_pass'];
		$this->db_name = $GLOBALS['config']['db_name'];
		$this->charset = $GLOBALS['config']['charset'];
		//创建PDO
		$this->connDb();
		//设置异常模式
		$this->setErrMode();
	}

	/**
	 * POD创建以及连接方法
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 * @return   [type]     [description]
	 */
	private function connDb(){
		try {
			$dsn = "{$this->db_type}:host={$this->db_host};";
			$dsn .= "dbname={$this->db_name};charset={$this->charset}";
			$this->pdo = new PDO($dsn,$this->db_user,$this->db_pass);
		} catch (PDOException $e) {
			$this->printError("PDO对象创建失败");
		}
	}

	/**
	 * 设置POD错误模式
	 * 
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 */
	private function setErrMode(){
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * 执行bool数据返回的sql语句
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 * @return   [boolean]     [true/false]
	 */
	public function exec($sql){
		try {
			return $this->pdo->exec($sql);
		} catch (Exception $e) {
			$this->printError("SQL语句错误");
		}
	}

	/**
	 * 获取一行数据
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 * @param    [string]     $sql [查询语句]
	 * @return  [array]
	 */
	public function fetchOne($sql){
		try {
			$PDOStatment = $this->pdo->query($sql);
			return $PDOStatment->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			$this->printError("SQL语句错误");
		}
	}

	/**
	 * 获取多行数据
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 * @param    [string]     $sql [查询语句]
	 * @return   [array]          [返回所有结果集]
	 */
	public function fetchAll($sql){
		try {
			$PDOStatment = $this->pdo->query($sql);
			return $PDOStatment->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			$this->printError("SQL语句错误");
		}
	}

	/**
	 * 获取结果个数
	 * @Author   Rain
	 * @DateTime 2017-05-04
	 * @param    [String]     $sql [查询语句]
	 * @return   [int]          [返回结果个数]
	 */
	public function rowCount($sql){
		try {
			$PDOStatment = $this->pdo->query($sql);
			return $PDOStatment->rowCount();
		} catch (PDOException $e) {
			$this->printError("SQL语句错误");
		}
	}
}


 ?>