<?php 
namespace Home\Model;
use \Frame\Libs\Db;
use \Frame\Libs\BaseModel;
/**
 * ========================
 * Description  : 默认模型
 * Author       : Rain
 * ========================
 */
final class IndexModel extends BaseModel{

	public function fetchAll(){
		$sql = "SELECT * FROM user ORDER BY id DESC";
		return $this->pdo->fetchAll($sql);
	}
}

 ?>