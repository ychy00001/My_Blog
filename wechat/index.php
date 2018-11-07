<?php

include_once "wxBizMsgCrypt.php";

// 第三方发送消息给公众平台
$encodingAesKey = "EgwKjH2K9RcWuavbYSKxa0sLFX57FDSC5A4SfZfIIMT";
$token = "weixin";
$timeStamp = "1409304348";
$nonce = "abcde";
$appId = "wx055749028ba82804";
$GLOBALS['type_xml'] = require_once("./type-xml.php");

define("TOKEN", $token);  
// 验证用户
if(isset($_GET['echostr'])){
	if(valid()){
		echo $_GET["echostr"];
	}
}else{
	//处理消息
	responseMsg();
}



function responseMsg(){
	$postStr = file_get_contents("php://input");
	if (!empty($postStr)){  
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);  
            $fromUsername = $postObj->FromUserName;  
            $toUsername = $postObj->ToUserName;  
            $msgType = trim($postObj->MsgType);  
            $time = time();  
           	switch ($msgType) {
           		//文本消息
           		case 'text':
           			$keyword = trim($postObj->Content);
					if(!empty( $keyword ))  
		            {  
		            	switch ($keyword) {
		            		case '欢迎':
		            			$textTpl = $GLOBALS['type_xml']['text'];
		            			$msgType = "text";  
					            $contentStr = "欢迎来到远方小镇";  
					            $resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType, $contentStr);  
		            			break;
		            		case '图文':
		            		    $textTpl = $GLOBALS['type_xml']['news'];
		            		    $itemTpl = $GLOBALS['type_xml']['item'];
		            		    $count = 1;
		            			$msgType = "news";  
		            			$title = "鄙视你";  
					            $desc = "哈哈哈哈哈"; 
					            $imgUrl = "http://ychy00001.xin/aaaa.png"; 
					            $itemcontent = sprintf($itemTpl,$title,$desc,$imgUrl,$imgUrl);
					            $resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$count,$itemcontent);  
		            			break;
		            		default:
		            		    $textTpl = $GLOBALS['type_xml']['text'];
		            			$msgType = "text";  
		            			$tuling = file_get_contents("http://www.tuling123.com/openapi/api?key=9fdb8e82a91a4cb0a131a4eb41940232&info=".$keyword);
		            			$returnMsg = json_decode($tuling);
					            $contentStr = $returnMsg->text;  
					            $resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType, $contentStr);  
		            			break;
		            	}
		               
		                echo $resultStr;
		            }
           			break;

           		//语音消息
           		case "voice":
           			$recognition = $postObj->Recognition;
           			$textTpl = $GLOBALS['type_xml']['text'];
        			$msgType = "text";  
        			$tuling = file_get_contents("http://www.tuling123.com/openapi/api?key=9fdb8e82a91a4cb0a131a4eb41940232&info=".$recognition);
        			$returnMsg = json_decode($tuling);
		            $contentStr = $returnMsg->text;  
		            $resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType, $contentStr);  
           			break;
           		default:
           			$textTpl = $GLOBALS['type_xml']['text'];
        			$msgType = "text";  
		            $contentStr = "欢迎来到远方小镇";  
		            $resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType, $contentStr);  
           			break;
           	}
           echo $resultStr; 

    }else {  
        echo "不对不对";  
        exit;  
    }  
};


function valid(){
	$signature = $_GET["signature"];  
    $timestamp = $_GET["timestamp"];  
    $nonce = $_GET["nonce"];  
              
    $token = TOKEN;
    $tmpArr = array($token, $timestamp, $nonce);  
    // use SORT_STRING rule  字典序排序  
    sort($tmpArr, SORT_STRING);  
    //|拼接  
    $tmpStr = implode( $tmpArr );  
    //|sha1加密  
    $tmpStr = sha1( $tmpStr );  
    //|判断是否相等  
    if( $tmpStr == $signature ){  
        return true;  
    }else{  
        return false;  
    }  
}