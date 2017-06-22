<?php
/**
 * ========================
 * Description  : 默认控制器
 * Author       : Rain
 * ========================
 */

namespace Home\Controller;
use \Home\Model\IndexModel;
use \Frame\Libs\BaseController;
use \Home\Model\LinksModel;
use \Home\Model\CategoryModel;
use \Home\Model\ArticleModel;
use \Frame\Vendor\Pager;

class IndexController extends BaseController{
	/**
	 * 首页显示方法
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 */
	public function index(){
		//获取友情链接
		$links = LinksModel::getInstance()->fetchAll();
		//无限级文章分类模块
		$categorys = CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAllWithJoin());
		//获取文档那月归档
		$datas = ArticleModel::getInstance()->fetchAllWithJoinAndCount();

		//构建查询条件
		$where = "2>1";
		if(!empty($_REQUEST['category_id'])){
			$where .= " AND category_id ='".$_REQUEST['category_id']."'";
		}
		if(!empty($_REQUEST['title'])){
			$where .= " AND title LIKE'%".$_REQUEST['title']."%'";
		}
        if(!empty($_REQUEST['date'])){
            $where .= " AND date_format(from_unixtime(article.addate),'%Y年%m月') = '".$_REQUEST['date']."'";
        }

		//分页
		$pagesize = 8;
		$page = !empty($_GET['page'])?$_GET['page']:1;
		$startrow = ($page-1)*$pagesize;
		$records = ArticleModel::getInstance()->rowCount($where);
		$orderby = 'id DESC';
		$params = array(
			'a' => ACTION,
			'c' => CONTROLLER,
			);
		if(!empty($_REQUEST['category_id'])){
			$params['category_id'] = $_REQUEST['category_id'];
		}
		if(!empty($_REQUEST['title'])){
			$params['title'] = $_REQUEST['title'];
		}


		//获取文章级联查询内容
		$articles = ArticleModel::getInstance()->fetchAllWithJoin($where,$orderby,$startrow,$pagesize);

		//根据文章长度计算动态显示高度 未加px
		//前端需要进行一定的添加
		foreach ($articles as $key => $value) {
			foreach ($value as $index => $content) {
				if($index == 'content'){
					$len = strlen($content);
					if($len < 10000){
						$articles[$key]['height'] = 160;
					}else if($len >= 10000 && $len < 20000){
						$articles[$key]['height'] = ($len/100)+60;
					}else if($len >= 20000 && $len < 30000){
						$articles[$key]['height'] = ($len/100);
					}else{
						$articles[$key]['height'] = 350;
					}
				}
			}
		}

		$pageObj = new Pager($pagesize,$page,$records,$params);
		//单个分页信息显示
        $pageMsgArr['pagePrevStr'] = $pageObj->showPrevStr();
		$pageMsgArr['pageNextStr'] = $pageObj->showNextStr();
		$pageMsgArr['pageMsgStr'] = $pageObj->showPagMsgStr();
		$pageStr = $pageObj->showPageStr();
		$this->smarty->assign(array(
			'links' => $links,
			'categorys' => $categorys,
			'datas' => $datas,
			'articles' => $articles,
			'pageStr' => $pageStr,
			'pageMsgArr' => $pageMsgArr,
			));

		$this->smarty->display("index.html");
	}

	/**
	 * 博文目录
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 */
	public function showList(){
		//获取友情链接
		$links = LinksModel::getInstance()->fetchAll();
		//无限级文章分类模块
		$categorys = CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAllWithJoin());
		//获取文档那月归档
		$datas = ArticleModel::getInstance()->fetchAllWithJoinAndCount();


		//构建查询条件
		$where = "2>1";
		if(!empty($_REQUEST['category_id'])){
			$where .= " AND category_id ='".$_REQUEST['category_id']."'";
		}
		if(!empty($_REQUEST['title'])){
			$where .= " AND title LIKE '%".$_REQUEST['title']."%'";
		}

		if(!empty($_REQUEST['date'])){
            $where .= " AND date_format(from_unixtime(addate),'%Y年%m月') = '".$_REQUEST['date']."'";
        }

		//分页
		$pagesize = 30;
		$page = !empty($_GET['page'])?$_GET['page']:1;
		$startrow = ($page-1)*$pagesize;
		$records = ArticleModel::getInstance()->rowCount($where);
		$orderby = 'id DESC';
		$params = array(
			'a' => ACTION,
			'c' => CONTROLLER,
			);
		if(!empty($_REQUEST['category_id'])){
			$params['category_id'] = $_REQUEST['category_id'];
		}
		if(!empty($_REQUEST['title'])){
			$params['title'] = $_REQUEST['title'];
		}


		//获取文章级联查询内容
		$articles = ArticleModel::getInstance()->fetchAllWithJoin($where,$orderby,$startrow,$pagesize);
		$pageObj = new Pager($pagesize,$page,$records,$params);
		//单个分页信息显示
        $pageMsgArr['pagePrevStr'] = $pageObj->showPrevStr();
		$pageMsgArr['pageNextStr'] = $pageObj->showNextStr();
		$pageMsgArr['pageMsgStr'] = $pageObj->showPagMsgStr();

		$pageStr = $pageObj->showPageStr();
		$this->smarty->assign(array(
			'links' => $links,
			'categorys' => $categorys,
			'datas' => $datas,
			'articles' => $articles,
			'pageStr' => $pageStr,
			'pageMsgArr' => $pageMsgArr,
			));

		$this->smarty->display("list.html");
	}


	/**
	 * 内容页面显示
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 */
	public function content(){
		//获取友情链接
		$links = LinksModel::getInstance()->fetchAll();
		//无限级文章分类模块
		$categorys = CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAllWithJoin());
		//获取文档那月归档
		$datas = ArticleModel::getInstance()->fetchAllWithJoinAndCount();
		$id = $_GET['id'];
		$article = ArticleModel::getInstance()->fetchOneWithJoin($id);

		//更新阅读数
		ArticleModel::getInstance()->updateRead($id);

		//获取前一条或者后一条文章数据
		$prevNext[] = ArticleModel::getInstance()->fetchOne("id<$id","id desc");
		$prevNext[] = ArticleModel::getInstance()->fetchOne("id>$id");

		$this->smarty->assign(array(
			'article' => $article,
			'links' => $links,
			'categorys' => $categorys,
			'datas' => $datas,
			'prevNext' => $prevNext,
			));
		$this->smarty->display("content.html");
	}

	/**
	 * 点赞方法
	 * @Author   Rain
	 * @DateTime 2017-05-08
	 */
	public function praise(){
		$addr = $_GET['addr'];
		$id = $_GET['id'];
		if(!isset($_SESSION['praise']) || $_SESSION['praise'][$addr] != $id){
			$res = ArticleModel::getInstance()->updatePriaise($id);
			if($res){
				$_SESSION['praise'][$addr] = $id;
				echo json_encode(array(
					'result'=>'success'
				));
			}else{
				echo json_encode(array(
					'result'=>'fail',
					'msg'=>'点赞失败,请重试'
				));
			}
		}else{
			echo json_encode(array(
				'result'=>'fail',
				'msg'=>'已经点过赞了'
			));
		}
	}


}