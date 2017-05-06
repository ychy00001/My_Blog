<?php 
/**
 * ========================
 * Description  : 后台用户模型类 负责模型数据库查询
 * Author       : Rain
 * ========================
 */

namespace Admin\Model;

use \Frame\Libs\BaseModel;
final class UserModel extends BaseModel{

	protected $table = "user";

	/**
	 * 获取所有用户数据
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @return   [Array]     [返回所有用户信息]
	 */
	public function fetchAll(){
		$sql = "SELECT * FROM {$this->table}";
		return $this->pdo->fetchAll($sql);
	}

	/**
	 * 删除用户数据
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
	 * 插入用户数据
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
	 * 获取一行用户数据
	 * @Author   Rain
	 * @DateTime 2017-05-05
	 * @param    [integer]     $id [用户编号]
	 * @return   [array]         [用户数据关联数组]
	 */
	public function fetchOne($id){
		$sql = "SELECT * FROM {$this->table} where id = {$id}";
		return $this->pdo->fetchOne($sql);
	}

	/**
	 * 更新用户数据
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

	/**
	 * 用户登陆时的更新操作
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @param    [type]     $data [description]
	 * @param    [type]     $id   [description]
	 * @return   [type]           [description]
	 */
	public function loginUpdate($data,$id){
		$str = "";
		foreach ($data as $key => $value) {
			$str .= "{$key}='$value',";
		}
		$str .= "login_times=login_times+1";

		$sql = "UPDATE {$this->table} set {$str} WHERE id={$id}";
		return $this->pdo->exec($sql);
	}
}
 ?>
