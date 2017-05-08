<?php 
/**
 * ========================
 * Description  : 前台分类模型
 * Author       : Rain
 * ========================
 */
namespace Home\Model;

use \Frame\Libs\BaseModel;
final class CategoryModel extends BaseModel{

	protected $table = "category";

	/**
	 * 获取无限级分类
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 */
	public function categoryList($arr,$level=0,$pid=0){
		static $result_arr = array();
		foreach ($arr as $row) {
			if($row['pid'] == $pid){
				$row['level'] = $level;
				$result_arr[] = $row;
				$this->categoryList($arr,$level+1,$row['id']);
			}
		}
		return $result_arr;
	}

	/**
	 * 获取链表查询的分类数据 关联该分类的文章
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 * @return   [array]     [每个分类有多少文章]
	 */
	public function fetchAllWithJoin(){
		$sql = "SELECT category.*,count(article.id) as article_num FROM {$this->table} ";
		$sql .= " LEFT JOIN article ON category.id = article.category_id ";
		$sql .= " GROUP BY category.id";
		return $this->pdo->fetchAll($sql);
	}
}

 ?>