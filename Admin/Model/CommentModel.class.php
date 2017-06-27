<?php
namespace Admin\Model;
use \Frame\Libs\BaseModel;
//定义最终的CommentModel类
final class CommentModel extends BaseModel
{
	//受保护的数据表名
	protected $table = "comment";

	//获取多行数据
	public function fetchAllWithJoin($where="2>1",$orderby="id desc",$startrow=0,$pagesize=10)
	{
		$sql = "SELECT comment.*,user.username,article.title,";
		$sql .= "a.content AS parent_content FROM comment ";
		$sql .= "LEFT JOIN user ON user.id=comment.user_id ";
		$sql .= "LEFT JOIN article ON article.id=comment.article_id ";
		$sql .= "LEFT JOIN comment AS a ON a.id=comment.pid";
		$sql .= " WHERE {$where}";
		$sql .= " ORDER BY {$orderby}";
		$sql .= " LIMIT {$startrow},{$pagesize}";
		return $this->pdo->fetchAll($sql);
	}
}