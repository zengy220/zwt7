<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>后台管理系统</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link rel="stylesheet" href="/Public/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="/Public/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="/Public/css/fullcalendar.css" />
    <link rel="stylesheet" href="/Public/css/matrix-style.css" />
    <link rel="stylesheet" href="/Public/css/matrix-media.css" />
    <link rel="stylesheet" href="/Public//css/uniform.css" />
    <link href="/Public/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="/Public/css/jquery.gritter.css" />
    <!-- <link rel="stylesheet" type="text/css" href="/Public/Admin/Css/Admin-default.css" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/ui-frame/ui.css" /> -->
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Css/Admin-default.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/animate/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/rickshaw/rickshaw.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/nvd3/nv.d3.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/mcustomscrollbar/jquery.mCustomScrollbar.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/jquery/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/fontawesome/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/dropzone/dropzone.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/Plugins/animate/animate.min.css" />

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
        <div id="breadcrumb"> <a href="javascript:;" class="tip-bottom">菜单管理</a> <a href="#" class="current">菜单列表</a> </div>
    </div>

      
            <div id="org"></div> 


          

                  <form id="question-form" class="form-horizontal" action="/home/Question/edit/id/<?php echo ($id); ?>/questionnaire_id/<?php echo ($questionnaire_id); ?>" method="post">

                        <input type="hidden" name="questionnaire_id" value="<?php echo ($questionnaire["id"]); ?>">
                        <input type="hidden" id="questionnaire_type" value="<?php echo ($questionnaire["type"]); ?>">

                        <input type="hidden" name="id" value="<?php echo ($question["id"]); ?>">
                        
                        <div class="form-group">
                            <blockquote class="blockquote-warning">
                                <h3><strong>编辑问题</strong></h3>
                            </blockquote>
                        </div>

                        <div class="form-group">
                            <label class="col-md-1 col-xs-12 control-label">问题名称</label>
                            <div class="col-md-6 col-xs-12">                                            
                                <input name="name" type="text" class="form-control question-name" value="<?php echo ($question["name"]); ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-1 col-xs-12 control-label">
                                问题选项
                            </label>
                            <div class="col-md-7 col-xs-12 option-list">
                                <?php if(is_array($optionsList)): $i = 0; $__LIST__ = $optionsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; switch($item["type"]): case "radio": ?><div class="option-item radio_option">
                                                <input name="-" type="radio" <?php if(isset($standardList[$i-1]))echo 'checked' ?> />
                                                <div>
                                                    <input type="text" value="<?php echo ($item["text"]); ?>" class="form-control" placeholder="请输入选项文本" />
                                                    <img class="option-del" src="/Public/img/btn-del.png" title="删除该选项">
                                                </div>
                                            </div><?php break;?>

                                        <?php case "checkbox": ?><div class="option-item checkbox_option">
                                                <input type="checkbox" <?php if(isset($standardList[$i-1]))echo 'checked' ?> />
                                                <div>
                                                    <input type="text" value="<?php echo ($item["text"]); ?>" class="form-control" placeholder="请输入选项文本" />
                                                    <img class="option-del" src="/Public/img/btn-del.png" title="删除该选项">
                                                </div>
                                            </div><?php break;?>

                                        <?php case "text": ?><div class="option-item text_option">
                                                <textarea class="form-control"><?php echo (unicodedecode($standardList)); ?></textarea>
                                                <img class="option-del" src="/Public/img/btn-del.png" title="删除该选项">
                                            </div><?php break;?>

                                        <?php case "radio_othertext": ?><div class="option-item radio_othertext_option">
                                                <input name="-" type="radio" <?php if(isset($standardList[$i-1]))echo 'checked' ?> />
                                                <div>
                                                    <strong style="position: absolute;line-height: 25px;">其他：</strong>
                                                    <input style="margin-left:40px;opacity: <?php if($questionnaire['type']=='exam')echo '1';else echo '0.3'; ?>;" type="text" class="form-control" value="<?php if(isset($standardList[$i-1]))echo unicodeDecode($standardList[$i-1]) ?>" <?php if($questionnaire['type']!='exam')echo 'disabled'; ?> />
                                                    <img class="option-del" src="/Public/img/btn-del.png" title="删除该选项">
                                                </div>
                                            </div><?php break;?>

                                        <?php case "checkbox_othertext": ?><div class="option-item checkbox_othertext_option">
                                                <input type="checkbox" <?php if(isset($standardList[$i-1]))echo 'checked' ?> />
                                                <div>
                                                    <strong style="position: absolute;line-height: 25px;">其他：</strong>
                                                    <input style="margin-left:40px;opacity: <?php if($questionnaire['type']=='exam')echo '1';else echo '0.3'; ?>;" type="text" class="form-control" value="<?php if(isset($standardList[$i-1]))echo unicodeDecode($standardList[$i-1]) ?>" <?php if($questionnaire['type']!='exam')echo 'disabled'; ?> />
                                                    <img class="option-del" src="/Public/img/btn-del.png" title="删除该选项">
                                                </div>
                                            </div><?php break; endswitch; endforeach; endif; else: echo "" ;endif; ?>
                            </div>

                            <?php if(($questionnaire["type"]) == "exam"): ?><input id="standard" name="standard" type="hidden"  value='<?php echo ($question["standard"]); ?>' /><?php endif; ?>
                            <input id="options" name="options" type="hidden" value='<?php echo ($question["options"]); ?>' />
                        </div>

                        <div class="form-group">
                            <label class="col-md-1 col-xs-12 control-label"></label>
                            <div class="col-md-2 col-xs-12">                                            
                                <div class="btn-group">
                                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    添 加 选 项 
                                  </button>             
                                  <ul class="dropdown-menu alter-option-list" role="menu">
                                    <li><a type="radio" class="btn" href="#"> 单 选 项 </a></li>
                                    <li><a type="checkbox" class="btn" href="#"> 多 选 项 </a></li>
                                    <li><a type="text" class="btn" href="#"> 文 本 输 入 </a></li>
                                    <li><a type="radio_othertext" class="btn" href="#">单选其他 - 文本</a></li>
                                    <li><a type="checkbox_othertext" class="btn" href="#">多选其他 - 文本</a></li>
                                  </ul>
                                </div>
                            </div>
                            <?php if(isset($errorNote)): ?><div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <strong><?php echo ($errorNote); ?></strong>
                                </div><?php endif; ?>      
                        </div>

                        <div id="question-extendinfo">
                            <?php if(($questionnaire["type"]) == "exam"): ?><div class="extend-row">
                                    <label>分数</label> <input name="score" type="text" class="form-control" value="<?php echo ($question["score"]); ?>" />
                                </div><?php endif; ?>

                            <div class="extend-row">
                                <label>排序</label> <input name="sort" type="text" class="form-control" value="<?php echo ($question["sort"]); ?>" />
                            </div>

                            <div class="extend-row" style="background: none;">
                                <a id="submit" class="btn btn-info btn-block">提 交 问 题</a>
                            </div>
                        </div>

                    </form>



   
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
    <script type="text/javascript" src="/Public/Admin/Plugins/jquery/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/Plugins/jquery/jquery-ui.js"></script>
    <script type="text/javascript" src="/Public/Admin/Plugins/bootstrap/bootstrap.js"></script>
    <script type="text/javascript" src="/Public/Admin/Plugins/datatables/jquery-dataTables.js"></script>
    <script type="text/javascript" src="/Public/Admin/Plugins/bootstrap/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/Public/Admin/Plugins/bootstrap/bootstrap-select.js"></script>
    <script type="text/javascript" src="/Public/Admin/Plugins/ui-frame/plugins.js"></script>
    <script type="text/javascript" src="/Public/Admin/Plugins/ui-frame/actions.js"></script>
    <script type="text/javascript" src="/Public/Admin/Plugins/dropzone/dropzone.js"></script>
    <script type="text/javascript" src="/Public/Admin/Plugins/dropzone/dropzone.js"></script>
    <script type="text/javascript" src="/Public/js/questions-optionManager.js"></script>


    <script type="text/javascript">
function add1(){
    var input1 = document.createElement('input');
    input1.setAttribute('type', 'text');
    input1.setAttribute('name', 'organizers[]');
    input1.setAttribute('class', 'git');
    
    var btn1 = document.getElementById("org");
    btn1.insertBefore(input1,null);
}
</script>

</body>
</html>