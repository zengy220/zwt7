<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<title>问卷调查</title>
<link href="/Public/web/css/common.css" rel="stylesheet" type="text/css" />
<link href="/Public/web/css/style.css" rel="stylesheet" type="text/css" />
<script  type="text/JavaScript" src="/Public/web/js/jquery-1.11.1.min.js"></script>
<script  type="text/JavaScript" src="/Public/web/js/common.js"></script>
</head>
<style type="text/css">
body{
overflow-x:hidden;
}
img{
width: 100%;
display: block;
}
</style>

<body>
			<p>问卷调查评分</p>
			<table border="1">
			    <tr>
			        <td>姓名</td>
			        <td><?php echo ($question_score['user_name']); ?></td>
			    </tr>
			    <tr>
			        <td>年龄</td>
			        <td><?php echo ($question_score['age']); ?></td>
			    </tr>
			    <tr>
			        <td>联系方式</td>
			        <td><?php echo ($question_score['phone']); ?></td>
			    </tr>
			    <tr>
			        <td>体质指数(BMI)</td>
			        <td><?php echo ($question_score['bmi']); ?></td>
			    </tr>
			    <?php if(is_array($arr_all)): $i = 0; $__LIST__ = $arr_all;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?><tr>
				        <td><?php echo ($vs["property"]); ?>值</td>
				        <td><?php echo ($vs["count"]); ?></td>
			    	</tr><?php endforeach; endif; else: echo "" ;endif; ?>

			</table>
			
</body>
</html>