<?php 
/**
 * ========================
 * Description  : 文章管理控制器
 * Author       : Rain
 * ========================
 */

namespace Admin\Controller;
use \Admin\Model\ArticleModel;
use \Admin\Model\CategoryModel;
use \Frame\Libs\BaseController;
use \Frame\Vendor\Pager;

final class ArticleController extends BaseController{

	/**
	 * 后台文章管理首页
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 */
	public function index(){
		$this->denyAccess();
		//初始化分页参数
		$where = "2>1";
		$params = array(
			'c' => 'Article',
			'a' => 'index'
			);
		$pagesize = 10;
		$page = isset($_GET['page'])?$_GET['page']:1;
		$startrow = ($page-1)*$pagesize;
		$orderby = " id desc";
		if(!empty($_REQUEST['category_id'])){
			$where .= " AND category_id='{$_REQUEST['category_id']}'";
			$params['category_id
			'] = $_REQUEST['category_id'];
		}
		if(!empty($_REQUEST['keyword'])){
			$where .= " AND title LIKE '%".$_REQUEST['keyword']."%'";
			$params['keyword
			'] = $_REQUEST['keyword'];
		}
		$records = ArticleModel::getInstance()->rowCount($where);
		//创建分页对象
		$pageObj = new Pager($pagesize,$page,$records,$params);
		$pageStr = $pageObj->showPageStr();

		$articles = ArticleModel::getInstance()->fetchAllWithJoin($where,$orderby,$startrow,$pagesize);

		$categorys = CategoryModel::getInstance()->categoryLists(
				CategoryModel::getInstance()->fetchAll()
			);

		$this->smarty->assign("pageStr",$pageStr);
		$this->smarty->assign("articles",$articles);
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("index.html");
	}

	/**
	 * 添加文章
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 */
	public function add(){
		$categorys = CategoryModel::getInstance()->categoryLists(
				CategoryModel::getInstance()->fetchAll()
			);
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("add.html");
	}

	/**
	 * 插入文章
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 */
	public function insert(){
		$data['category_id'] = $_POST['category_id'];
		$data['user_id'] = $_SESSION['uid'];
		$data['title'] = $_POST['title'];
		$data['content'] = $_POST['content'];
		$data['orderby'] = $_POST['orderby'];
		$data['top'] = isset($_POST['orderby'])?1:0;
		$data['addate'] = time();
		//调用模型类对象insert()方法
		ArticleModel::getInstance()->insert($data);
		$this->jump("文章添加成功","?c=Article");
	}

	/**
	 * 文章删除功能
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 * @return   [type]     [description]
	 */
	public function delete(){
		$this->denyAccess();
		$id = $_GET["id"];
		ArticleModel::getInstance()->delete($id);
		$this->jump("文章删除成功","?c=Article");
	}
}
 ?>
