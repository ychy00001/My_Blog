<?php 

return array(

		"text"=>"<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
			    <FromUserName><![CDATA[%s]]></FromUserName>
			    <CreateTime>%d</CreateTime>
			    <MsgType><![CDATA[%s]]></MsgType>
			    <Content><![CDATA[%s]]></Content>
				</xml>",
		"news"=>"<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%d</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>%d</ArticleCount>
				<Articles>%s></Articles>
				</xml>",
		"item"=>"<item>
				<Title><![CDATA[%s]]></Title> 
				<Description><![CDATA[%s]]></Description>
				<PicUrl><![CDATA[%s]]></PicUrl>
				<Url><![CDATA[%s]]></Url>
				</item>",

	);