<?php 

namespace Home\Model;
use \Frame\Libs\BaseModel;

final class UserModel extends BaseModel{
	protected $table = 'user';

	public function getIdByName($name){
		$sql = "SELECT id FROM  user WHERE username='$name'";
		return $this->pdo->fetchOne($sql);
	}
}