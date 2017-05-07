<?php 
/**
 * ========================
 * Description  : Smarty对外封装类 便于类自动加载
 * Author       : Rain
 * ========================
 */
namespace Frame\Vendor;
//引入smarty框架
require_once(FRAME_PATH."Vendor".DS."Smarty".DS."libs".DS."Smarty.class.php");

final class Smarty extends \Smarty{}

 ?>