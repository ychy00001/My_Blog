<?php 
/**
 * ========================
 * Description  : 文章模型
 * Author       : Rain
 * ========================
 */

namespace Admin\Model;

use \Frame\Libs\BaseModel;

final class ArticleModel extends BaseModel{
	protected $table = "article";

	public function fetchAllWithJoin($where="2>1",$orderby="id desc",$startrow=0,$pagesize=10){
		$sql = "SELECT article.*,category2.classname,user.username FROM article LEFT JOIN category2 ON category2.id = article.category_id LEFT JOIN user ON  user.id = article.user_id";
		$sql .= " WHERE {$where}";
		$sql .= " ORDER BY {$orderby}";
		$sql .= " LIMIT {$startrow},{$pagesize}";
		return $this->pdo->fetchAll($sql);
	}
}
 ?>
