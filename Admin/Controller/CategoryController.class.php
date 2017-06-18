<?php 
/**
 * ========================
 * Description  : 分类管理控制器
 * Author       : Rain
 * ========================
 */

namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\CategoryModel;
use \Frame\Vendor\Pager;

final class CategoryController extends BaseController {

	/**
	 * 文章分类首页
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 */
	public function index(){
		$this->denyAccess();
		$where = "2>1";
		$params = array(
			'c' => 'Article',
			'a' => 'index'
			);
		$pagesize = 10;
		$page = isset($_GET['page'])?$_GET['page']:1;
		$startrow = ($page-1)*$pagesize;
		$orderby = " id desc";
		if(!empty($_REQUEST['keyword'])){
			$where .= " AND category.classname LIKE '%".$_REQUEST['keyword']."%'";
			$params['keyword
			'] = $_REQUEST['keyword'];
		}
		$records = CategoryModel::getInstance()->rowCount($where);
		//创建分页对象
		$pageObj = new Pager($pagesize,$page,$records,$params);
		$pageStr = $pageObj->showPageStr();


		$categorys = CategoryModel::getInstance()->fetchAllWithJoin($where,$orderby,$startrow,$pagesize);
		//调用层级显示方法
		$categorys = CategoryModel::getInstance()->categoryLists($categorys);
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->assign("pageStr",$pageStr);
		$this->smarty->display("index.html");
	}

	/**
	 * 文章分类添加
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 */
	public function add(){
		$this->denyAccess();
		$categorys = CategoryModel::getInstance()->categoryLists(CategoryModel::getInstance()->fetchAll());
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("add.html");
	}

	/**
	 * 插入文章分类
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 */
	public function insert(){
		$this->denyAccess();
		$data['classname'] = $_POST['classname'];
		$data['orderby'] = $_POST['orderby'];
		$data['pid'] = $_POST['pid'];
		CategoryModel::getInstance()->insert($data);
		$this->jump("文章分类添加成功","?c=Category");
	}

	/**
	 * 删除文章分类
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 */
	public function delete(){
		$this->denyAccess();
		$id = $_GET["id"];
		CategoryModel::getInstance()->delete($id);
		$this->jump("文章分类删除成功","?c=Category");
	}

	/**
	 * 编辑文章分类
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 * @Return   [type]     [description]
	 */
	public function edit(){
		$id = $_GET["id"];
		$this->denyAccess();
		$arr = CategoryModel::getInstance()->fetchOne("id='$id'");
		$categorys = CategoryModel::getInstance()->categoryLists(CategoryModel::getInstance()->fetchAll());
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->assign("arr",$arr);
		$this->smarty->display("edit.html");
	}

	/**
	 * 更新文章分类
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 */
	public function update(){
		$this->denyAccess();
		$id = $_POST['id'];
		$data['classname'] = $_POST['classname'];
		$data['orderby'] = $_POST['orderby'];
		$data['pid'] = $_POST['pid'];
		$resu = CategoryModel::getInstance()->update($data,$id);
		if($resu){
			$this->jump("文章分类更新成功","?c=Category");
		}
	}
}
