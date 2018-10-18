 $(function(e) {
			//选项卡
 	 function tabs(tabTit,on,tabCon){
				
		$(tabCon).each(function(){
			 
		  $(this).children().eq(0).show();
		  });
	$(tabTit).each(function(){
	  $(this).children().eq(0).addClass(on);
	  });
     $(tabTit).children().hover(function(){

        $(this).addClass(on).siblings().removeClass(on);
       var index = $(tabTit).children().index(this);
      $(tabCon).eq(index).show().siblings().hide();
    });
     }
      tabs(".tab-title","active",".tab-cot");
   })
//产品轮播
$(document).ready(function () {
	
	/* 图片滚动效果 */
//	$(".mr_frbox").slide({
//		titCell: "",
//		mainCell: ".mr_frUl ul",
//		autoPage: true,
//		effect: "leftLoop",
//		autoPlay: true,
//		vis: 4
//	});
	
	/* 鼠标悬停图片效果 */
	$(".mr_zhe_hover").css("top", $('.mr_zhe').eq(0).height());
	$("li").mouseout(function (e) {
		if ((e.pageX < $(this).offset().left || e.pageX > ($(this).offset().left + $(this).width())) || (e.pageY < $(this).offset().top || e.pageY > ($(this).offset().top + $(this).height()))) {
			$(this).find('.mr_zhe_i').show();
			$(this).find('.mr_zhe_hover').hide().stop().animate({ top: '190px' }, { queue: false, duration: 190 });
			return false;
		}

	});
	$('.mr_zhe').mouseover(function (event) {
		$(this).find('.mr_zhe_i').hide();
		$(this).find('.mr_zhe_hover').show().stop().animate({ top: '190px' }, { queue: false, duration: 190 });
		return false;
	});
	
	 // banner 切换
    (function() {
        var banner = $('#banner1'),
            pic_c  = banner.find('.pics'),
            pics   = pic_c.children(),
            idx_c  = banner.find('.idxs'),
            idxs   = idx_c.children(),
            btns   = banner.find('.btns a'),
            prev   = btns.filter('.prev'),
            next   = btns.filter('.next'),

            len    = pics.length,
            idx    = 0,
            prev_i = -1,
            max_i  = len - 1,
            curr_p = pics.eq(idx),
            curr_i = idxs.eq(idx),
            delay  = 5000,
            timeout = -1;
 		banner.find("li").eq(0).css("display","block");
        var lilength=pics.length;
        if (lilength>1){

        $(window).on('load', function() {
            idx_recu(0, 1500/len, function() {
                setTimeout(function() {
                    curr_i.addClass('on');
                    auto();
                }, 300);
       idxs.hover(hover);
       
            });
            
        });
        function hover(){
        	
            idx = $(this).index();
            if (idx === prev_i) return;
            fade(idx);
        }
        function fade(idx) {
            clearTimeout(timeout);
            prev_i = idx;
            curr_p.stop(false,true).fadeOut(300);
            curr_p = pics.eq(idx).stop(false,true).fadeIn(300);
            curr_i.removeClass('on');
            curr_i = idxs.eq(idx).addClass('on');
            auto();
        }
     
        function idx_recu(idx, delay, func) {
            temp = idxs.eq(idx);
            if (temp.length) {
                temp.css('margin-top',0).fadeIn(500);
                setTimeout(function() {
                    idx_recu(idx+1, delay, func);
                }, delay);
            } else {
                func();
                return;
            }
        }
        function auto() {
            timeout = setTimeout(function() {
                fade(idx===max_i? idx=0: ++idx);
            }, delay);
        }
        }
    }());
	
	//当鼠标划入，停止轮播图切换
	  $(".content_middle").hover(function(){
	    clearInterval(timer);
	 },function(){
	    timer = setInterval(run2,800);
	 }) 
	
	//添加浮动
	var xfblock='<div class="tool fixed bradius5 tc fz-12">'+
  				'<i class="f-phone "></i>'+
  	            '<b class="fz-12 ">全国招商热线 </b>'+
  				'<b class="fz-12 ">13874855000 </b>'+
  				'<img src="/Public/web/images/top_ewm.jpg" width="76" height="76"/>'+
  	            '<a href="javascript:;" class="top-fbtn topbt-false "></a>'+
  				'<a href="javascript:;" class="top-fbtn topbt-true fn-hide"></a>'+
          		'</div>' 
      $("body").append(xfblock)    		
	//返回顶部
		function b() {
			var h = $(window).height();
			var t = $(document).scrollTop();
		    if(t>h)
			  {$(".topbt-false").addClass("fn-hide");
			  $(".topbt-true").removeClass("fn-hide") 
			  }
			else
			  {
			  $(".topbt-false").removeClass("fn-hide");
			  $(".topbt-true").addClass("fn-hide") 
			  }
			}
		$(document).ready(function() {
			b();
			$(".topbt-true").bind('click', function() {
			$("html, body").animate({
			"scroll-top":0},"fast");
			})	
		}),
		$(window).scroll(function() {
			b()
		});
	});
	