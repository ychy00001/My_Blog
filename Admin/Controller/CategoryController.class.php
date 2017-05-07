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

final class CategoryController extends BaseController {

	public function index(){
		$this->denyAccess();
		$categorys = CategoryModel::getInstance()->fetchAll();
		//调用层级显示方法
		$categorys = CategoryModel::getInstance()->categoryLists($categorys);
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->display("index.html");
	}

	public function add(){
		$this->denyAccess();
		$this->smarty->display("add.html");
	}

	public function insert(){
		$this->denyAccess();
		$data['classname'] = $_POST['classname'];
		$data['orderby'] = $_POST['orderby'];
		$data['pid'] = $_POST['pid'];
		CategoryModel::getInstance()->insert($data);
		$this->jump("文章分类添加成功","?c=Category");
	}

	public function delete(){
		$this->denyAccess();
		$id = $_GET["id"];
		CategoryModel::getInstance()->delete($id);
		$this->jump("文章分类删除成功","?c=Category");
	}

	public function edit(){
		$id = $_GET["id"];
		$this->denyAccess();
		$category = CategoryModel::getInstance()->fetchOne($id);
		$this->smarty->assign("category",$category);
		$this->smarty->display("edit.html");
	}

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
 ?>
