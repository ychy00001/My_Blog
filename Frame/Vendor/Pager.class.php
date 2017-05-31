<?php 
/**
 * ========================
 * Description  : 分页类
 * Author       : Rain
 * ========================
 */
namespace Frame\Vendor;

final class Pager{
	private $pagesize;
	private $page;
	private $pages;
	private $records;
	private $first;
	private $prev;
	private $next;
	private $last;
	private $url;

	/**
	 * 分页类构造方法 创建分页
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 * @param    [integer]     $pagesize [每页显示长度]
	 * @param    [type]     $page     [当前页]
	 * @param    [type]     $records  [总记录数]
	 * @param    array      $params   [url链接所需参数]
	 */
	public function __construct($pagesize=10,$page=1,$records=0,$params=array()){
		$this->pagesize = $pagesize;
		$this->page = $page;
		$this->records = $records;
		$this->pages = ceil($this->records/$this->pagesize);
		$this->url = $this->getUrl($params);
		$this->first = $this->getFirst();
		$this->prev = $this->getPrev();
		$this->next = $this->getNext();
		$this->last = $this->getLast();
	}

	/**
	 * 获取分页跳转连接
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 * @param    [array]     $params [description]
	 * @return   [string]             [跳转连接]
	 */
	private function getUrl($params){
		/*
		参数$params
		array(
			'c' = 'Article',
			'a' = 'index',
			'category_id' = '11',
		);
		 */

		$str="";
		foreach ($params as $key => $value) {
			$str .= "$key=$value&";
		}
		return "?".$str."page=";

	}

	/**
	 * 首页对应字符串显示
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 * @return   [string]     [首页对应字符串]
	 */
	private function getFirst(){
		if($this->page == 1){
			return "【首页】";
		}else{
			return "<a href='{$this->url}1'>【首页】</a>";
		}
	}

	/**
	 * 上一页对应字符串显示
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 * @return   [string]     [上一页html字符串]
	 */
	private function getPrev(){
		if($this->page == 1){
			return "【上一页】";
		}else{
			return "<a href='{$this->url}".($this->page-1)."'>【上一页】</a>";
		}
	}

	/**
	 * 获取下一页字符串
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 * @return   [string]     [获取上一页对应字符串]
	 */
	private function getNext(){
		if($this->page == $this->pages){
			return "【下一页】";
		}else{
			return "<a href='{$this->url}".($this->page+1)."'>【下一页】</a>";
		}
	}

	/**
	 * 获取最后一页字符串
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 * @return   [string]     [获取最后一页字符串]
	 */
	private function getLast(){
		if($this->page == $this->pages){
			return "【末页】";
		}else{
			return "<a href='{$this->url}{$this->pages}'>【末页】</a>";
		}
	}

	/**
	 * 显示分页字符串
	 * @Author   Rain
	 * @DateTime 2017-05-07
	 * @return   [string]     [分页字符串]
	 */
	public function showPageStr(){
		$str = "";
		if($this->pages > 1){
			$str = "共有{$this->records}条记录";
			$str .= " 每页显示{$this->pagesize}";
			$str .= " 当前{$this->page}/{$this->pages}";
			$str .= " {$this->getFirst()}{$this->getPrev()}{$this->getNext()}{$this->getLast()}";
		}else{
			$str = "共有{$this->records}条记录";
		}
		return $str;
	}

	/**
	 * 获取前一页数据
	 * @Author   Rain
	 * @DateTime 2017-05-09
	 * @return   [type]     [description]
	 */
	public function showPrevStr(){
		return $this->getPrev();
	}

	/**
	 * 获取后一页数据
	 * @Author   Rain
	 * @DateTime 2017-05-09
	 * @return   [type]     [description]
	 */
	public function showNextStr(){
		return $this->getNext();
	}

	/**
	 * 获取分页具体信息
	 * @Author   Rain
	 * @DateTime 2017-05-09
	 * @return   [type]     [description]
	 */
	public function showPagMsgStr(){
		$str = "";
		if($this->pages > 1){
			//总条目数
			// $str = "总条目:{$this->records}";
			$str .= "&ensp;{$this->page}/{$this->pages}";
		}else{
			$str = "共有{$this->records}条记录";
		}
		return $str;
	}
}


 ?>