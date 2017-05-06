<?php 
/**
 * ========================
 * Description  : 友情链接控制器类
 * Author       : Rain
 * ========================
 */

namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\LinksModel;
final class LinksController extends BaseController{

	/**
	 * 显示友情链接首页
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function index(){
		$links = LinksModel::getInstance()->fetchAll();
		$this->smarty->assign("links",$links);
		$this->smarty->display("index.html");
	}

	/**
	 * 删除友情连接
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function delete(){
		$this->denyAccess();
		$id = $_GET['id'];
		$modelObj = LinksModel::getInstance();
		if ($modelObj->delete($id)) {
			$this->jump("id={$id}的链接删除成功","?c=Links&a=index");
		}else{
			$this->jump("id={$id}的链接添加失败","?c=Links&a=index");
		}
	}

	/**
	 * 添加友情连接
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function add(){
		$this->denyAccess();
		$this->smarty->display("add.html");
	}

	/**
	 * 插入新连接
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function insert(){
		$this->denyAccess();
		$data['domain'] = $_POST['domain'];
		$data['url'] = $_POST['url'];
		$data['orderby'] = $_POST['orderby'];
		//调用模型类对象insert()方法写入数据
		LinksModel::getInstance()->insert($data);
		$this->jump("添加成功","?c=Links");
	}

	/**
	 * 编辑友情连接
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function edit(){
		$this->denyAccess();
		$id = $_GET['id'];
		$link = LinksModel::getInstance()->fetchOne("id='$id'");
		$this->smarty->assign("link",$link);
		$this->smarty->display("edit.html");
	}

	/**
	 * 更新友情连接
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function update(){
		$this->denyAccess();

		$id = $_POST['id'];
		$data['domain'] = $_POST['domain'];
		$data['url'] = $_POST['url'];
		$data['orderby'] = $_POST['orderby'];
		LinksModel::getInstance()->update($data,$id);
		$this->jump("修改成功","?c=Links");
	}

}

 ?>