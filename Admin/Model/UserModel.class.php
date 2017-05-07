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

	//设置表名
	protected $table = "user";

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
