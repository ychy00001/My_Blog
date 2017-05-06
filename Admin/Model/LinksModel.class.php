<?php 
/**
 * ========================
 * Description  : 友情连接模型类
 * Author       : Rain
 * ========================
 */

namespace Admin\Model;

use \Frame\Libs\BaseModel;
final class LinksModel extends BaseModel{

	protected $table = "links";

	/**
	 * 查询所有友情链接
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function fetchAll(){
		$sql = "SELECT * FROM {$this->table}";
		return $this->pdo->fetchAll($sql);
	}

	/**
	 * 删除一条友情连接
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @param    [integer]     $id [要删除的id]
	 * @return   [boolean]         [返回删除结果]
	 */
	public function delete($id){
		$sql = "DELETE FROM {$this->table} WHERE id = {$id}";
		return $this->pdo->exec($sql);
	}

	/**
	 * 插入一条友情连接
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @param    [array]     $data [插入的数据]
	 * @return   [boolean]           [返回结果]
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
	 * 获取某一条件下友情链接的个数
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @param    [string]     $where [查询条件]
	 * @return   [array]            [一行数据]
	 */
	public function rowCount($where){
		$sql = "SELECT * FROM {$this->table} WHERE $where";
		return $this->pdo->rowCount($sql);
	}

	/**
	 * 获取一行数据
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @param    [string]     $where [获取条件]
	 * @return   [array]            [获取到的数据]
	 */
	public function fetchOne($where="2>1"){
		$sql = "SELECT * FROM {$this->table} where {$where} LIMIT 1";
		return $this->pdo->fetchOne($sql);
	}

	/**
	 * 更新友情连接
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @param    [array]     $data [要更新的数据]
	 * @param    [integer]     $id   [更新id]
	 * @return   [boolean]           [执行结果]
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