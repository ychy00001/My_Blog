<?php 
/**
 * ========================
 * Description  : 分类模型
 * Author       : Rain
 * ========================
 */

namespace Admin\Model;

use \Frame\Libs\BaseModel;
final class CategoryModel extends BaseModel{
	protected $table = "category";

    /**
	 * 获取无限极分类数据
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 * 
     * @param $arrs
     * @param int $level
     * @param int $pid
     * @return array
     */
	public function categoryLists($arrs,$level=0,$pid=0){
		static $categorys = array();
		foreach ($arrs as $row) {
			if($row['pid'] == $pid){
				$row['level'] = $level;
				$categorys[] = $row;
				$this->categoryLists($arrs,$level+1,$row['id']);
			}
		}
		return $categorys;
	}

	// select category.`*`,count(article.id) from category left join article on category.id = article.category_id group by category.id limit 20;
	public function fetchAllWithJoin($where="2>1",$orderby="id desc",$startrow=0,$pagesize=10){
		$sql = "SELECT category.*,count(article.id) art_num FROM category LEFT JOIN article ON category.id = article.category_id";
		$sql .= " WHERE {$where}";
		$sql .= " GROUP BY category.id";
		$sql .= " ORDER BY {$orderby}";
		$sql .= " LIMIT {$startrow},{$pagesize}";
		return $this->pdo->fetchAll($sql);
	}
}
