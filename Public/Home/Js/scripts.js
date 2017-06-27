/*-----------------------------------------------------------------------------------*/
/*	POSTS GRID
/*-----------------------------------------------------------------------------------*/ 
$(window).load(function(){
    var $container = $('.blog-grid');

    var gutter = 30;
    var min_width = 345;
    $container.imagesLoaded( function(){
        $container.masonry({
            itemSelector : '.post',
            gutterWidth: gutter,
            isAnimated: true,
              columnWidth: function( containerWidth ) {
                var box_width = (((containerWidth - gutter)/2) | 0) ;

                if (box_width < min_width) {
                    box_width = (((containerWidth - gutter)/2) | 0);
                }

                if (box_width < min_width) {
                    box_width = containerWidth;
                }

                $('.post').width(box_width);

                return box_width;
              }
        });
        $container.css( 'visibility', 'visible' ).parent().removeClass( 'loading' );
    });
});

/*-----------------------------------------------------------------------------------*/
/*	VIDEO
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($) {
    		$('.video').fitVids();
    	});	

    
/*-----------------------------------------------------------------------------------*/
/*	BUTTON HOVER
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($)  {
$("a.button, .forms fieldset .btn-submit, #commentform input#submit").css("opacity","1.0");
$("a.button, .forms fieldset .btn-submit, #commentform input#submit").hover(function () {
$(this).stop().animate({ opacity: 0.85 }, "fast");  },
function () {
$(this).stop().animate({ opacity: 1.0 }, "fast");  
}); 
});

/*-----------------------------------------------------------------------------------*/
/*	IMAGE HOVER
/*-----------------------------------------------------------------------------------*/		
		
jQuery(document).ready(function($) {	
$('.quick-flickr-item').addClass("frame");
$('.frame a').prepend('<span class="more"></span>');
});

jQuery(document).ready(function($) {
        $('.frame').mouseenter(function(e) {

            $(this).children('a').children('span').fadeIn(300);
        }).mouseleave(function(e) {

            $(this).children('a').children('span').fadeOut(200);
        });
    });	

/*-----------------------------------------------------------------------------------*/
/*	MENU
/*-----------------------------------------------------------------------------------*/
ddsmoothmenu.init({
	mainmenuid: "menu",
	orientation: 'h',
	classname: 'menu',
	contentsource: "markup"
})

// 点赞
function addPraise(event){
    event = event ? event : window.event; 
    var obj = event.srcElement ? event.srcElement : event.target; 
    var $obj = $(obj);

    //网络连接参数设置
    var param = {
        type:"get",
        url:"",
        data:"",
        dataType: "json",
        success:function(data){
           if(data.result == 'success'){
                var num = $obj.text();
                $obj.text(parseInt(num)+1);
           }else{
                //提示错误
                alert(data.msg);
           }
        }
    };
   
    //如果是a标签
    param.type = "get";
    param.url = $obj.attr("href");
    $.ajax(param);
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