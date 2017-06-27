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
use \Frame\Vendor\Pager;
final class LinksController extends BaseController{

	/**
	 * 显示友情链接首页
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	public function index(){
		$this->denyAccess();
		$where = "2>1";
		$params = array(
			'c' => 'Links',
			'a' => 'index'
			);
		$pagesize = 10;
		$page = isset($_GET['page'])?$_GET['page']:1;
		$startrow = ($page-1)*$pagesize;
		$orderby = " id desc";
		if(!empty($_REQUEST['keyword'])){
			$where .= " AND links.domain LIKE '%".$_REQUEST['keyword']."%'";
			$where .= " OR links.url LIKE '%".$_REQUEST['keyword']."%'";
			$params['keyword
			'] = $_REQUEST['keyword'];
		}
		$records = LinksModel::getInstance()->rowCount($where);
		//创建分页对象
		$pageObj = new Pager($pagesize,$page,$records,$params);
		$pageStr = $pageObj->showPageStr();


		$links = LinksModel::getInstance()->fetchAll($where,$orderby,$startrow,$pagesize);
		$this->smarty->assign("links",$links);
		$this->smarty->assign("pageStr",$pageStr);
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