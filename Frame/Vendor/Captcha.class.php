<?php 
/**
 * ========================
 * Description  : 验证码对象类
 * Author       : Rain
 * ========================
 */

namespace Frame\Vendor;

final class Captcha{

	//私有成员属性 
	private $code;//验证码字符串
	private $codelen;//验证码长度
	private $width; //图片宽度
	private $height; //图片高
	private $fontsize;//文字大小
	private $fontfile;//字体文件
	private $img; //图像资源

	/**
	 * 构造方法 验证码图片
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @param    integer    $codelen  [description]
	 * @param    integer    $width    [description]
	 * @param    integer    $height   [description]
	 * @param    integer    $fontsize [description]
	 */
	public function __construct($codelen=4,$width=85,$height=37,$fontsize=18){
		$this->codelen = $codelen;
		$this->width = $width;
		$this->height = $height;
		$this->fontsize = $fontsize;
		$this->fontfile = "./Public/Admin/Images/msyh.ttf";
		$this->createCode();
		$this->createImg();
		$this->createBg();
		$this->createText();
		$this->outPut();
	}

	/**
	 * 生成数字验证码方法
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @return   [type]     [description]
	 */
	private function createCode(){
		$str = "";
		$arr_list = array_merge(range('A','Z'),range(0,9),range('a','z'));
		shuffle($arr_list);
		$arr_index = array_rand($arr_list,4);
		foreach ($arr_index as $index) {
			$str .= $arr_list[$index];
		}		
		$this->code = $str;
	}

	/**
	 * 生成验证码画布
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @return   [type]     [description]
	 */
	private function createImg(){
		//创建画布 生成图像资源
		$this->img = imagecreatetruecolor($this->width, $this->height);

	}

	/**
	 * 为验证码画布添加颜色
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @return   [type]     [description]
	 */
	private function createBg(){
		$color = imagecolorallocate($this->img, mt_rand(0,250), mt_rand(0,250), mt_rand(0,250));
		imagefilledrectangle($this->img,0,0,$this->width, $this->height, $color);

	}

	/**
	 * 背景图添加文字信息
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	private function createText(){
		$color = imagecolorallocate($this->img, mt_rand(0,250), mt_rand(0,250), mt_rand(0,250));
		imagettftext($this->img, $this->fontsize, 3, 12, 31, $color, $this->fontfile, $this->code);
	}


	/**
	 * 输出图片
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 */
	private function outPut(){
		header("content-type:image/png");
		imagepng($this->img);
		imagedestroy($this->img);
	}

	/**
	 * 获取验证码
	 * @Author   Rain
	 * @DateTime 2017-05-06
	 * @return   返回统一小写验证码
	 */
	public function getCode(){
		//验证码全小写
		return strtolower($this->code);
	}

}

 ?>