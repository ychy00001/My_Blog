<?php
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\CommentModel;
use \Frame\Vendor\Pager;
//定义最终的CommentController类
final class CommentController extends BaseController
{
	//显示评论
	public function index()
	{
		$this->denyAccess();
		//初始化分页参数
		$where = "2>1";
		$params = array(
			'c' => 'Comment',
			'a' => 'index'
			);
		$pagesize = 10;
		$page = isset($_GET['page'])?$_GET['page']:1;
		$startrow = ($page-1)*$pagesize;
		$orderby = " comment.id desc";
		if(!empty($_REQUEST['keyword'])){
			$where .= " AND article.title LIKE '%".$_REQUEST['keyword']."%'";
			$params['keyword
			'] = $_REQUEST['keyword'];
		}
		$records = CommentModel::getInstance()->rowCount($where);
		//创建分页对象
		$pageObj = new Pager($pagesize,$page,$records,$params);
		$pageStr = $pageObj->showPageStr();

		//获所有的评论数据
		$comments = CommentModel::getInstance()->fetchAllWithJoin($where,$orderby,$startrow,$pagesize);
		//向模板赋值，并调用视图显示
		$this->smarty->assign("comments",$comments);
		$this->smarty->assign("pageStr",$pageStr);
		$this->smarty->display("index.html");
	}

	//删除评论
	public function delete()
	{
		$id = $_GET['id'];
		$res = CommentModel::getInstance()->delete($id);
		if($res){
			$this->jump("id={$id}的评论删除成功！","?c=Comment");
		}else{
			$this->jump("id={$id}的评论删除失败！","?c=Comment");
		}
		
	}
}