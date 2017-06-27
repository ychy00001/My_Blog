//ajax获取点击连接的数据 替换 .main中的内容
function loadContentFrame(event) {
	//网络连接参数设置
	var param = {
		type:"get",
		url:"",
		data:"",
		success:function(data){
			//截取字符串添加至内容位置
			var star_str = "<!-- MAIN -->";
			var end_str = "<!-- END MAIN -->";
			//开始标签需要减去字符串长度为了移除了上面两个标志位字符串
			var start_index = data.indexOf(star_str)+star_str.length;
			var end_index = data.lastIndexOf(end_str);
			var content = data.substring(start_index,end_index);
			$(".main").replaceWith(content);
			//存在textarea标签  进行渲染
			if(content.indexOf("<textarea") !== -1){
				//渲染Kind编辑器
				initKindEditor();
			}
			// checkbox 添加 点击事件
			$("input[name='top']").on("click", function(){
				if($(this).attr('checked') == "checked"){
					$(this).removeAttr('checked')
				}else{
					$(this).attr('checked','checked');
				}
			});
		}
	};

	//判断事件源
	if((typeof event=='string') && event.constructor==String){
		//说明event是一个url连接 （跳转连接） 添加/删除
		param.type = "get";
		param.url = event;
	}else{
		event = event ? event : window.event; 
		var obj = event.srcElement ? event.srcElement : event.target; 
		//这时obj就是触发事件的对象，可以使用它的各个属性 
		//还可以将obj转换成jquery对象，方便选用其他元素 
		var $obj = $(obj);
		//如果是a标签
		if($obj[0].localName == 'a'){
			//移除其他点击样式
			$("#main_nav").children().find(".sub_item").removeClass("active");
			//添加点击样式
			$obj.addClass("active");
			param.type = "get";
			param.url = $obj.attr("href");
			//侧边栏菜单刷新
			flushSideBarNav($obj);
		}else if($obj[0].localName == 'form'){
			param.type = $obj[0].method;
			//获取 www.xxx.com?action=xx&controll=xxx
			var actionUrl = $obj[0].action;
			var sub_flag = actionUrl.indexOf("?");
			//截取字符串 获取?action=xx&controll=xxx ?c=Article&a=insert
			param.url = actionUrl.substr(sub_flag,actionUrl.length);
			if($obj[0].length > 1){
				//循环添加url的参数
				for(var i=0;i<$obj[0].length-1;i++){
					//checkbox需要判断一下
					if($obj[0][i].name == 'top' || $obj[0][i].name == 'status'){
						if($obj[0][i].checked == true){
							param.data += $obj[0][i].name;
							param.data += "=" + 1 +"&";
						}
						continue;
					}else{
						param.data += $obj[0][i].name;
						param.data += "=" + $obj[0][i].value +"&";
					}
				}
				//category_id=1&title=testtest&orderby=50&top=0&=&content=&=添加
				param.data = param.data.substr(0,param.data.length-1);
			}
		}
	}
	//请求网络
	$.ajax(param);
	//取消网页链接跳转
	disableEvent(event);
}

function disableEvent(event){
	if((typeof event=='string') && event.constructor==String){
		//事件源是url 连接
		return false;
	}else if (event && event.preventDefault) {
		//事件源是点击事件
		event.preventDefault();
	} else {
		//兼容ie
		window.event.returnValue = false; 
	}
}

//动态加载 KindEditor在线编辑器
function initKindEditor(){
	$.getScript('./Public/Admin/Js/editor/kindeditor-min.js', function() {
		$.getScript('./Public/Admin/Js/editor/lang/zh_CN.js', function() {
			KindEditor.basePath = './Public/Admin/Js/editor/';
			KindEditor.create('textarea[name="content"]');
		});
	});
}	

//刷新侧边栏
function flushSideBarNav(click_obj){
	//获取所有li
	$siderbarItems = click_obj.parents("#main_nav").children();
	$siderbarItems.each(function(index,obj){
		//不是当前条目
		if($(obj).children("a")[0].innerText != click_obj.parents(".collapse").siblings("a")[0].innerText){
			//有active 移除
			if($(obj).children("a").hasClass("active")){
				//如果是打开的 先关闭子菜单
				$(obj).children("a").click();
				//没有子菜单的移除active样式
				$(obj).children("a").removeClass("active");
			}
		}
	});
}

//表单验证
function checkForm(event)
{
	var pattern1 = /^[\S]{1,20}$/;
	var pattern2 = /^[\d]{2}$/;
	if(!pattern1.test(document.form1.classname.value))
	{
		window.alert("分类名称没有填写或格式不正确！");
		document.form1.classname.focus();
		disableEvent(event);
		return false;
	}else if(!pattern2.test(document.form1.orderby.value))
	{
		window.alert("排序没有填写或格式不正确！");
		document.form1.orderby.focus();
		disableEvent(event);
		return false;
	}
	return true;
}