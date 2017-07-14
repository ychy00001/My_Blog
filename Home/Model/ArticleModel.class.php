<?php 
/**
 * ========================
 * Description  : 前台文章模型类
 * Author       : Rain
 * ========================
 */

namespace Home\Model;

use \Frame\Libs\BaseModel;
final class ArticleModel extends BaseModel{

	protected $table = "article";

	/**
	 * 获取按年月分类的文章信息
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 * @Return   返回所有文章信息的条目数
	 */
	public function fetchAllWithJoinAndCount(){
		//构建查询SQL语句
		$sql = "SELECT date_format(from_unixtime(addate),'%Y年%m月') AS months,count(id) AS article_count";
		$sql .= " FROM article GROUP BY months";
		$sql .= " ORDER BY months DESC";
		return $this->pdo->fetchAll($sql);
	}

	/**
	 * 获取文章信息并关联用户表分类表
	 * 获取作者以及分类
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 * @Param    string     $where    [查询条件]
	 * @Param    string     $orderby  [排序条件]
	 * @Param    integer    $startrow [开始未位置]
	 * @Param    integer    $pagesize [offset]
	 * @Return   关联表返回所有文章的信息
	 */
	public function fetchAllWithJoin($where="2>1",$orderby="id DESC",$startrow=0,$pagesize=10){
		$sql = "SELECT article.*,user.name,category.classname from article";
		$sql .= " LEFT JOIN user ON user.id=article.user_id ";
		$sql .= " LEFT JOIN category ON category.id=article.category_id ";
		$sql .= " WHERE {$where}";
		$sql .= " ORDER BY  {$orderby}";
		$sql .= " LIMIT {$startrow},{$pagesize}";
		return $this->pdo->fetchAll($sql);
	}

	/**
	 * 获取点赞 并且评论数最多的三条数据
	 * @Author   Rain
	 * @DateTime 2017-07-11
	 */
	public function fetchRecommArticle(){
		// select * from article order by `read` desc,praise desc limit 3;
		$sql = "SELECT * from $this->table ";
		$sql .= " ORDER BY 'read' DESC,praise DESC ";
		$sql .= " limit 3";
		return $this->pdo->fetchAll($sql);
	}

	/**
	 * 获取指定id连表查询的数据 (查询一篇文章)
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 * @Param    [integer]     $id [需要查询的编号]
	 * @Return   [array]         [一条数据]
	 */
	public function fetchOneWithJoin($id){
		$sql = "SELECT article.*,user.name,category.classname FROM article ";
		$sql .= " LEFT JOIN user ON user.id=article.user_id ";
		$sql .= "LEFT JOIN category ON category.id = article.category_id ";
		$sql .= "WHERE article.id ={$id}";
		return $this->pdo->fetchOne($sql);
	}

	/**
	 * 更新阅读数
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 * @Param    [integer]     $id [文章id]
	 * @Return   [boolean]     [执行结果]
	 */
	public function updateRead($id){
		$sql = "UPDATE {$this->table} SET `read`=`read`+1 where id = {$id}";
		return $this->pdo->exec($sql);
	}

	/**
	 * 更新点赞数
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 * @param    [integer]     $id [文章id]
	 * @return   [boolean]         [执行结果]
	 */
	public function updatePriaise($id){
		$sql = "UPDATE {$this->table} SET praise=praise+1 where id = {$id}";
		return $this->pdo->exec($sql);
	}

	/**
	 * 更新评论数
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 * @param    [integer]     $id [文章id]
	 * @return   [boolean]         [执行结果]
	 */
	public function updateCommentCount($id){
		$sql = "UPDATE {$this->table} SET comment_count=comment_count+1 where id = {$id}";
		return $this->pdo->exec($sql);
	}


}

 ?>