<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="cn">
<head>
<title>后台管理平台</title>
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
<style>
.public_menu{margin-left:10px;}
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
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>首页</a><a href="/Home/User/roleList" class="current">角色列表</a> </div>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
	<?php
 if($menu=="list") { ?>
	<a href="/Home/User/roleAdd/" class="btn btn-success btn">角色新增</a>
     <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>数据</h5>
            </div>
          <div class="widget-content ">
            <table class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th style="width:28px;text-align:left;">序号</th>
                  <th>角色名称</th>
                  <!-- <th>角色身份</th> -->
                  <th>角色编码</th>
				  
				  <th>角色类型</th>
				  <th>状态</th>
                  <th style="width:15%;text-align:left;">操作</th>
                </tr>
              </thead>
              <tbody>
			   <?php if(is_array($roleList)): $i = 0; $__LIST__ = $roleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?><tr>
                  <td><?php echo ($i); ?></td>
				  <td><?php echo ($vs["role_name"]); ?></td>
				  
				 <!--  <td><?php if($vs["role_position"] == 0): ?>系统管理员<?php endif; if($vs["role_position"] == 1): ?>区域经理<?php endif; if($vs["role_position"] == 2): ?>客服<?php endif; if($vs["role_position"] == 3): ?>业务员<?php endif; if($vs["role_position"] == 4): ?>财务<?php endif; ?></td> -->
				  <td><?php echo ($vs["role_num"]); ?></td>
                  <td><?php if($vs["role_identity"] == 0): ?>总部角色<?php else: ?>分部角色<?php endif; ?>/<?php if( $vs["role_type"] == 0 ): ?>系统角色<?php else: ?>自定义角色<?php endif; ?></td>
				  <td><?php if( $vs["role_status"] == 1 ): ?>启用<?php else: ?>禁用<?php endif; ?></td>
				  
				  <td style="width:15%;text-align:left;">
					<a href="/Home/User/roleEdit/editId/<?php echo ($vs["role_Id"]); ?>" class="btn btn-primary btn-mini">编辑</a> 
					<?php if( $vs["role_type"] != 0 ): ?>| <a href="/Home/User/roleDel/delId/<?php echo ($vs["role_Id"]); ?>" class="btn btn-danger btn-mini" onclick= "if(confirm('是否确定删除!')==false)return  false; ">删除</a><?php endif; ?>
					
				  </td>
				  
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
              </tbody>
            </table>
          </div>
        </div>
	<?php
 } else { ?>
     <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5><?php echo ($menu_titles); ?></h5>
        </div>
        <div class="widget-content nopadding">
          <form action="<?php echo ($menu_from_url); ?>" method="post" class="form-horizontal">
		  
            <div class="control-group">
              <label class="control-label">名称 :</label>
              <div class="controls">
                <input type="text" class="span11" placeholder="角色名称" name="role_name" value="<?php echo ($role["role_name"]); ?>" <?php if($role['type'] == 'edit'): ?>readonly<?php endif; ?> style="width:300px;" />
              </div>
            </div>
			
			<div class="control-group">
              <label class="control-label">编号 :</label>
              <div class="controls">
				
                <!-- <input type="text" class="span11" placeholder="请输入两位数字" name="role_num" value="<?php echo ($role["role_num"]); ?>"  style="width:300px;"  <?php if($role['type'] == 'edit'): ?>readonly<?php endif; ?>/> -->
				
				<input type="text" class="span11" placeholder="请输入两位数字"  name="role_num" value="<?php echo ($role["role_num"]); ?>" id="role_num" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " maxlength="2" style="width:208px;" <?php if($role['type'] == 'edit'): ?>readonly<?php endif; ?>/> &nbsp;&nbsp;&nbsp;  <?php if($role['type'] == 'add'): ?><input type="button" name="点击" onclick="generate_number();" value="点击生成"/><?php endif; ?>
				
              </div>
            </div>

	
			<div class="control-group">
              <label class="control-label">类型 :</label>
              <div class="controls">
			    <label>
                  <input type="radio" name="role_identity" value='0' <?php if( $role["role_identity"] == 0 ): ?>checked<?php endif; ?>/>
                  总部角色&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                  <input type="radio" name="role_identity" value='1' <?php if( $role["role_identity"] == 1 ): ?>checked<?php endif; ?>/>
                  分部角色
				</label>
				
              </div>
            </div>
			
			
			<div class="control-group">
              <label class="control-label">登录状态 :</label>
              <div class="controls">
			    <label>
				  <input type="radio" name="role_status" value='1' <?php if( $role["role_status"] == 1 or $role["role_status"] == null ): ?>checked<?php endif; ?>/>
                  使用&nbsp;&nbsp;&nbsp;&nbsp;
				
                  <input type="radio" name="role_status" value='0' <?php if( $role["role_status"] == 0 and $role["role_status"] != null ): ?>checked<?php endif; ?>/>
                  禁用</label>
				
              </div>
            </div>
			
            <div class="control-group">
              <label class="control-label">选择权限 :</label>
              <div class="controls">
			    <?php if(is_array($menu_all)): $i = 0; $__LIST__ = $menu_all;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?><input type='checkbox' name='show_list_<?php echo ($vs["menu_Id"]); ?>' <?php if(text_role($role['role_Id'],$vs['menu_Id']) == true): ?>checked="checked"<?php endif; ?> value="<?php echo ($vs["menu_Id"]); ?>" ><span><?php echo ($vs["menu_name"]); ?></span> <br>
					<?php if(is_array($vs["son"])): $i = 0; $__LIST__ = $vs["son"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vf): $mod = ($i % 2 );++$i;?>&nbsp;&nbsp;<span class="public_menu">--<?php echo ($vf["menu_name"]); ?>:</span>
						<span>
							<input type='checkbox' name='show_list_<?php echo ($vf["menu_Id"]); ?>' <?php if( text_role($role['role_Id'],$vf['menu_Id']) == true): ?>checked="checked"<?php endif; ?> value="<?php echo ($vf["menu_Id"]); ?>">
						</span><br> 
						<?php if(is_array($vf["grandson"])): $i = 0; $__LIST__ = $vf["grandson"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vd): $mod = ($i % 2 );++$i;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="public_menu">----<?php echo ($vd["menu_name"]); ?>:</span>
							<span>
								<input type='checkbox' name='show_list_<?php echo ($vd["menu_Id"]); ?>' <?php if( text_role($role['role_Id'],$vd['menu_Id']) == true): ?>checked="checked"<?php endif; ?> value="<?php echo ($vd["menu_Id"]); ?>">
							</span><br><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
				 <br>
              </div>
            </div>
            <div class="form-actions" style="margin:0 106px;">
			  <input type="hidden" name="roleId" value="<?php echo ($role["role_Id"]); ?>"/>
			  <input type="hidden" name="type" value="<?php echo ($role["type"]); ?>"/>
              <button type="submit" class="btn btn-success"><?php echo ($role["menu_titles_button"]); ?></button>&nbsp;&nbsp;&nbsp;&nbsp;
			  <button type="button" class="btn btn-success" onclick="history.back();">返回</button>
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
<script>
//产生随机数 
function GetRandomNum(Min,Max)
{   
	var Range = Max - Min;   
	var Rand = Math.random();   
	return(Min + Math.round(Rand * Range));   
}   

//随机业务号的生成
function generate_number(){
	var random_number=GetRandomNum(01,99);
	$("#role_num").val(random_number);
}

</script>

<script src="/Public/js/matrix.js"></script> 
</script>
</body>
</html>