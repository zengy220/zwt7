<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>开始做题</title>
<!--手机端需要添加-->
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0"/>-->
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<!--手机端需要添加---->
<link rel="stylesheet" href="/Public/css/animate.min.css">
<script src="/Public/js/swiper.animate.min.js"></script>
<script src="/Public/js/swiper.min.js"></script>
<link rel="stylesheet" href="/Public/wj/css/test_rx.css">
<link rel="stylesheet" href="/Public/css/reset.css">
<link rel="stylesheet" href="/Public/css/swiper.min.css">
<link rel="stylesheet" href="/Public/css/toup.css">
<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
<script src="/Public/wj/js/jQuery.fontFlex.js"></script>
<script src="/Public/wj/js/jQuery.fontFlex.js"></script>
<!-- <script type="text/javascript" >
    function submit1()//第二种提交方式，用普通button按钮结合JavaScript提交
    {
        var form1=document.getElementById("form1");
        form1.action="/web/index/add";                //设置提交路径
        form1.submit();                            //提交
    }
    </script> -->
<script>
$(document).ready(function(e) {
	//320宽度的时候html字体大小是20px;、640宽度的时候html字体大小是40px;
	$('html').fontFlex(20, 40, 16); 
	//
     $(".dxt_box li").click(function(){
		$(this).addClass("on").siblings().removeClass("on");
		$(this).parent(".dxt_box").parent(".kcks_title_ts").attr("date-title",1);
		$(this).parent(".dxt_box").parent(".last").attr("date-title",0);

		});

		


		var problemIndex=1 ; //当前显示的问题索引
		var  problemNum = $("#form1 .swiper-slide").length;//获取问题个数
		var problemBox = $('#form1'),problemList = problemBox.find('.swiper-slide[data-swiper-slide-index]');
		//showProblemContent(1);//初始化显示第一个问题
       
        $('.swiper-container').on('change','.swiper-slide :input',function (){
              
              //console.log('change');
            var swiper_parent=$(this).parents('.swiper-slide'),swiper_index=swiper_parent.attr('data-swiper-slide-index'),swiper_mirror=$(".swiper-container .swiper-slide[data-swiper-slide-index="+swiper_index+"]").not(swiper_parent[0]);
              if(swiper_mirror.length){
       
                  var  name=$(this).attr('name'),type=this.type.toUpperCase()||'TEXT',val;
                  if(type=='TEXT'){
                  	 swiper_mirror.find(":input[name="+name+"]").val($(this).val());
                     }
                  

              }






        });
        

		var mySwiper  = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '',
        prevButton: '',
        slidesPerView: 1,
        paginationClickable: true,
        spaceBetween: 30,
        loop: true,
        allowTouchMove:false
    });

      $('.tj').click(function (){


         if(problemIndex<=1){
         
             return false;

         }
         
         mySwiper.slideTo(--problemIndex,1000);
          




      });


        $('ul.dxt_box li').click(function (){

             var _ul = $(this).parent();

             _ul.find('li').removeClass('on');

             $(this).addClass('on');






        });

		// 显示第几个问题
		function showProblemContent(index)
		{
		   /* if(problemIndex){
		        
		        problemList.eq(problemIndex-1).hide(); // 隐藏之前的问题


		      }
		        problemList.eq(index-1).show(); //显示当前问题
		       

		   */    
		    problemIndex = index; // 更新


		}
		$(".tj_zuotm").click(function(){
		     
		  // 检查提交内容youpu
		  if(!checkProblemContent(problemIndex)){
		     
		    alert('请选择');
		    return false;
		}
		// 判断是否有下一题
		if(problemNum>problemIndex){
              problemIndex = problemIndex?problemIndex+1:2;
              mySwiper.slideTo(problemIndex,1000);
               
		   //showProblemContent(problemIndex+1);
		   

		}else{
		  $('form').submit();


		}





 	
});

//表单内容检查
function checkProblemContent(index)
{
 
 var unpass = 0;

 
 //var problem = problemList.eq(index-1).find(':input[name]');
 var problem = $('.swiper-slide-active').find(':input[name]');
 problem.each(function (){

 var _this = $(this),name = _this.attr('name'),type=_this.attr('type')||'text',current;

 type =  type.toLowerCase();



 
 if(type=='radio'||type=='checkbox'){
            
          // current  = !problem.is('[name="'+name+'"]:checked');
          current  = !problem.is('[name="'+name+'"]:checked');
         
     }else{
 
          current = !_this.val();

 }

 unpass += current;
});

 return unpass > 0 ? false:true;
    
 
}





	});
</script>
</head>
<body>
<div class="wjdt_title">
  <h3>问卷调查</h3>
  <img src="/Public/wj/images/ls.svg" style="width:3rem; position:absolute; top:1rem; left:1rem; "> </div>
  <form method="post" id='form1' action='/web/index/add'>
<div class="dtks_box" >
   <!--题目-->
     <div class="swiper-container">
  <div class="swiper-wrapper">
    
    <?php if(is_array($option_middle)): foreach($option_middle as $k=>$ve): ?><div class="swiper-slide">
	  <div class="kcks_title_ts problem_box  " date-title="2" date-last="0">
	    <!-- <h4 class=" kctm_zzbt"><?php echo ($ve[0]['question_sort']); ?>.<?php echo ($ve[0]['question_name']); ?></h4> -->
	    <h4 class=" kctm_zzbt"><?php echo ($ve['number']); ?>.<?php echo ($ve[0]['question_name']); ?></h4>
	    <ul class="dxt_box">
	    	<?php if(is_array($ve)): foreach($ve as $key=>$vo): ?><li >
	    			<label> 
	    				<!-- 写一个判断如果是单选题则是这个如果是文字题就是另外一个 -->
	    				<?php if($vo["question_type"] == 1): ?><div class='divdan'>
		    					<input type="radio" name="<?php echo ($vo['question_id']); ?>" value ="<?php echo ($vo['id']); ?>" >
	    						<span style="float: none;display: inline-block;"><?php echo ($vo['name']); ?></span>
	    					</div><?php endif; ?>
	    				<?php if($vo["question_type"] == 3): ?><input type="text"  name="<?php echo ($vo['question_id']); ?>" value="" />
	    					<span style="float: none;display: inline-block;"><?php echo ($vo['name']); ?></span><?php endif; ?>

	    				
	    			</label> 
	    		</li><?php endforeach; endif; ?>	
    

	
	    </ul>
	  </div>
	</div><?php endforeach; endif; ?>
    <div class="swiper-slide">
    	<div class="kcks_title_ts last  problem_box"  date-title="2" date-last="1">
		<label class="dxt_box">姓名:</label>
          <div class="dxt_box">
            <input type="text" class="span11"  name="user_name" value="" id="user_name"  style="width:200px;"/>
          </div>
        <label class="dxt_box">年龄:</label>
          <div class="dxt_box">
            <input type="text" class="span11"  name="age" value="" id="age"  style="width:200px;"/>
          </div>
        <label class="dxt_box">联系电话:</label>
          <div class="dxt_box">
            <input type="text" class="span11"  name="phone" value="" id="phone"  style="width:200px;"/>
          </div>
	</div>
    </div>
    </div>
        </div>

    



	<!-- <div class="kcks_title_ts hide"  date-title="2" date-last="0">
		<h4 class="kctm_zzbt" name='question_name' value='<?php echo ($option_last[0]['question_id']); ?>'><?php echo ($option_last[0]['question_name']); ?></h4>
		<ul class="dxt_box">
		  <?php if(is_array($option_last)): foreach($option_last as $key=>$vo): ?><li name='option' value="<?php echo ($vo['id']); ?>"> <em></em><span><?php echo ($vo['name']); ?></span> </li> -->
	      		<!-- <input type="radio" name="option" value="<?php echo ($vo['id']); ?>"><?php echo ($vo['name']); ?> -->
	    	<!--<?php endforeach; endif; ?> -->
		<!-- </ul> -->
	<!-- </div> -->   
</div>
<!-- <input type="button" name="Submit" value="" onclick="submit1(this.form);" />   -->
<!--结束------------------------------------------>
<div class="kasj_db_but "> <a href="javascript:void(0)" class="tj_zuotm">提交选择</a> </div>
<div class="kasj_db_but "> <a href="javascript:void(0)" class="tj">上一题</a> </div>
</form>
	<script type="text/javascript">
	   $(".divdan").click(function(){
	        if($(this).find("input").attr("checked")==undefined){
	            var danname = $(this).find("input").attr("name");
	            $.each($("input[name='"+danname+"']"),function(i,val){
	                $(val).attr("checked",false);
	            });
	            $(this).find("input").attr("checked",true);
	            $(this).find("input").click();
	        }
	    });
		
	</script>
	
	<script>


	</script>


</body>
</html>