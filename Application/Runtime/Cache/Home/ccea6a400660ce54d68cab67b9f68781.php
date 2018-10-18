<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>后台管理平台</title><meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="/Public/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/Public/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="/Public/css/matrix-login.css" />
        <link href="/Public/font-awesome/css/font-awesome.css" rel="stylesheet" />
    </head>
    <body>
    <div id="login_box">
    <div class="left_login_box">
    <!-- <img src="/Public/images/lh_logo.png"> -->
    </div>
        <div id="loginbox">            
            <form id="loginform" class="form-vertical" action="/Home/Index/login" method="post" onsubmit="return check()">
				 <div class="control-group normal_text"> <h3>后台管理</h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"></i></span><input type="text" placeholder="用户名" name="name" id="username">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" placeholder="密码" name="password" id="password">
                        </div>
                    </div>
                </div>
				<div class="error-login">
					<span>请输入密码</span>
				</div>
                <div class="form-actions">
                    <span class="pull-right"><button class="btn btn-success" style="margin-left: 160px;" type="submit">登录</button></span>
					
				<!-- 	<span style="float: right; margin-right: 160px; margin-top: -30px;">
					<a href="/zhaohui/index.php"><button class="btn " type="button" >找回密码</button></a>
					</span> -->
                </div>
				
            </form>
        </div>
        </div>
        <script src="/Public/js/jquery.min.js"></script>  
        <script src="/Public/js/matrix.login.js"></script> 
    

</body></html>