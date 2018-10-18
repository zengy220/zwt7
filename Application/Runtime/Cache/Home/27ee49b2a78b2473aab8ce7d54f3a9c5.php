<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<title>后台管理</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="/Public/css/bootstrap.min.css" />
<link rel="stylesheet" href="/Public/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="/Public/css/fullcalendar.css" />
<link rel="stylesheet" href="/Public/css/matrix-style.css" />
<link rel="stylesheet" href="/Public/css/matrix-media.css" />
<link rel="stylesheet" href="/Public/css/uniform.css" />
<link href="/Public/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="/Public/css/jquery.gritter.css" />
<style type="text/css">
.table th,.table td {text-align:left}
</style>

</head>
<body>

<!--Header-part-->
<div id="header">
  <!-- <h1>介贷网后台管理系统</h1> -->
</div>
<link rel="stylesheet" href="/Public/css/page.css" />
<!--close-Header-part-->
<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#"  class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">欢迎 <?php echo $_SESSION['realName'];?></span></a>
      <ul class="dropdown-menu">
	  <!--
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
        <li class="divider"></li>
		-->
        
      </ul>
	  <li><a href="/Home/index/changepwd"><i class="icon-key"></i> 修改密码</a></li>
	  <li><a href="/Home/index/logout"><i class="icon-forward"></i> 退出</a></li>
    </li>
<!--
    <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> 消息</a></li>
        <li class="divider"></li>
        <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
        <li class="divider"></li>
        <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
        <li class="divider"></li>
        <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
    <li class=""><a title="" href="login.html"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
-->
  </ul>
</div>


<!--close-top-Header-menu-->
<!--start-top-serch-->
<div id="search">
  <!--<input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
  -->
</div>
<!--close-top-serch-->
<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i>系统</a>
  <ul>
	<li><a href="/Home/User"><i class="icon icon-home"></i> <span>首页中心</span></a> </li>
	<?php if(is_array($meuns_list)): $i = 0; $__LIST__ = $meuns_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="submenu"> <a href="javascript:;"><i class="icon icon-list"></i> <span><?php echo ($vo["menu_name"]); ?></span></a>
	    <ul <?php if($vo["key"] != null ): ?>style="display: block;"<?php endif; ?>>
		<?php if(is_array($vo['son'])): $i = 0; $__LIST__ = $vo['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li <?php if( strtolower($v['menu_url'])==$now_url ){ ?> class="active" <?php } ?>><a href="<?php echo ($v["menu_url"]); ?>" <?php if( strtolower($v['menu_url'])==$now_url ){ ?> style="color: rgb(255, 255, 255);" <?php } ?> ><?php echo ($v["menu_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
	<li class="content"> <span>内存使用</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width: <?php echo ($memory["c"]); ?>;" class="bar"></div>
      </div>
      <span class="percent"><?php echo ($memory["c"]); ?></span>
	  <div class="stat"><?php echo ($memory["a"]); ?>MB / 4000MB</div>
    </li>
  </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="/Home/User" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>首页</a><a href="/Home/User/menu_list" class="current">菜单列表</a> </div>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
	<?php
 if($menu=="list") { ?>
	<div class="span11"><a href="/Home/User/menu_add/" class="btn btn-success btn">新增菜单</a>
     <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>数据</h5>
            </div>
          <div class="widget-content ">
            <table class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th style="width:30px;">序号</th>
                  <th>菜单标题</th>
				  <th>等级</th>
				  <th>上级目录</th>
                  <th>菜单URL</th>
                  <th>状态</th>
				  <th>展示</th>
				  <th>排序</th>
				  <th>操作</th>
                </tr>
              </thead>
              <tbody>

			   <?php if(is_array($menu_list)): $i = 0; $__LIST__ = $menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?><tr>
                  <td><?php echo ($i); ?></td>
				  <td><?php echo ($vs["menu_name"]); ?></td>
                  <td><?php echo ($vs["menu_class_titile"]); ?></td>
				  <td><?php echo ($vs["menu_class_up"]); ?></td>
                  <td><?php echo ($vs["menu_url"]); ?></td>
				  <td><?php echo ($vs["menu_status"]); ?></td>
				  <td><?php echo ($vs["menu_show"]); ?></td>
				  <td><?php echo ($vs["menu_sort"]); ?></td>
				  <td>
					<a href='<?php if($vs["relation_Id"] == 0 and $vs["relation_Id"] != null): ?>javascript:; <?php else: ?>/Home/User/menu_capacity/u/<?php echo ($vs["menu_Id"]); endif; ?>' class='<?php if($vs["relation_Id"] == 0 and $vs["relation_Id"] != null): ?>btn-inverse<?php else: ?> btn-success<?php endif; ?>  btn btn-mini'>功能</a> |
					<a href="/Home/User/menu_set/u/<?php echo ($vs["menu_Id"]); ?>" class="btn btn-primary btn-mini">编辑</a> | 
					<a href="/Home/User/menu_del/u/<?php echo ($vs["menu_Id"]); ?>" class="btn btn-danger btn-mini" onclick= "if(confirm('是否确定删除!')==false)return  false; ">删除</a>
					
				  </td>	  
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
              </tbody>
            </table>
          </div>
        </div>
		  </div>

	<?php
 } else { ?>
     <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5><?php echo ($menu_title); ?></h5>
        </div>
        <div class="widget-content nopadding">
          <form action="<?php echo ($menu_from_url); ?>" method="post" class="form-horizontal">
            <div class="control-group">
              <label class="control-label">菜单名 :</label>
              <div class="controls">
                <input type="text" class="span11" placeholder="菜单名" name="menu_name" value="<?php echo ($menu_data["menu_name"]); ?>" style="width:220px;"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">层级 :</label>
              <div class="controls">
               <select name="relation_Id" id="relation_Id">
                  <option value="0"></option>
				  <?php if(is_array($list)): foreach($list as $key=>$vo): ?><option value="<?php echo ($vo["menu_Id"]); ?>" <?php if( $vo["menu_Id"] == $menu_data["relation_Id"] ): ?>selected<?php endif; ?> ><?php echo ($vo["menu_name"]); ?></option><?php endforeach; endif; ?>
                </select>(为空是一级目录)
              </div>
            </div>
            <div class="control-group control-single" <?php if($menu_data["menu_url"] == '' ): ?>style="display:none;"<?php endif; ?> >
              <label class="control-label" name="manu_url">菜单URL</label>
              <div class="controls" >
                <input type="text"  class="span11" placeholder="菜单URL" name="menu_url" id="menu_url" value="<?php echo ($menu_data["menu_url"]); ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">状态 :</label>
              <div class="controls">
			            <label>
                  <input type="radio" name="menu_status" value='0' <?php if( $menu_data["menu_status"] == 0 ): ?>checked<?php endif; ?>/>
                  禁用</label>
                <label>
                  <input type="radio" name="menu_status" value='1' <?php if( $menu_data["menu_status"] == 1 ): ?>checked<?php endif; ?>/>
                  使用</label>
   
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">展示 :</label>
              <div class="controls">
			            <label>
                  <input type="radio" name="menu_show" value='0' <?php if( $menu_data["menu_show"] == 0 ): ?>checked<?php endif; ?>/>
                  隐藏</label>
                <label>
                  <input type="radio" name="menu_show" value='1' <?php if( $menu_data["menu_show"] == 1 ): ?>checked<?php endif; ?>/>
                  显示</label>
   
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" name="manu_or">排序:</label>
              <div class="controls">
                <input type="text" class="span2" placeholder="排序" name="menu_sort" value="<?php echo ($menu_data["menu_sort"]); ?>" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
             </div>
            </div>
			 <div class="control-group">
              <label class="control-label" name="manu_or">验证码:</label>
              <div class="controls" style="cursor:pointer;">
              <input type="text" class="span2" name="verify"/><span><img src='/Home/User/verify/' onclick="this.src='/Home/User/verify/'+Math.random()" /></span> 
			  </div>
            </div>
			<input type="hidden" name="u" value="<?php echo ($menu_Id); ?>" />
			<input type="hidden" name="o" value="<?php echo ($menu); ?>" />
			
            <div class="form-actions" style="margin:0 180px;">
              <button type="submit" class="btn btn-success">确认</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-success" onclick="history.back();">返回</button>
            </div>
          </form>
        </div>
      </div>
    <?php
 } ?>
  
</div></div>
<!--end-main-container-part-->

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 后台管理系统 </div>
</div>


<!--end-Footer-part-->



<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/js/client.js"></script>
<script src="/Public/js/matrix.js"></script> 
<script src="/Public/js/timepicker/WdatePicker.js"></script> 
<script src="/Public/js/base.js"></script>


</body>
</html>