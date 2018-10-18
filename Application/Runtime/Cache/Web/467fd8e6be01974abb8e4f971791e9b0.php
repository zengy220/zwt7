<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Cache-Control" content="no-cache"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="format-detection" content="email=no"/>
<meta property="og:image" content="http://research.hnxjw.cn/Public/img/wx.png">
<title>痛经情况问卷调查表</title>
<link href="/Public/css/style.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="http://apps.bdimg.com/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="http://ku.zzfriend.com/js/ie.js"></script>

</head>
<script type="text/javascript">
    define = null;
    require = null;
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,
    appId: wx69c8b53849d51df2,
    timestamp: <?php echo ($signPackage["timestamp"]); ?>,
    nonceStr: <?php echo ($signPackage["nonceStr"]); ?>,
    signature: <?php echo ($signPackage["signature"]); ?>,
    jsApiList: [
        'onMenuShareTimeline',
        'onMenuShareAppMessage'
    ]
  });
  wx.ready(function () {
      var shareData = {

        tle: '痛经情况问卷调查表',
        desc: '痛经情况问卷调查表',
        link: 'research.hnxjw.cn/web/index/start/questionnaire_id/32',
        imgUrl: 'research.hnxjw.cn/Public/img/wx.png'
      };
      wx.onMenuShareAppMessage(shareData);
      wx.onMenuShareTimeline(shareData);
  });
</script>
<body>
<div style="display:none;"><img src="/Public/img/wx.png" alt=""></div>
<div class="whole" style=" position:relative;">
   <div class="pc_img">
      <img id="gif" />
   </div>
   <div class="dc_tit1">
      <img src="/Public/img/dc_tit.png" />
   </div>
   <a href="/web/index/index/questionnaire_id/<?php echo ($questionnaire_id); ?>"><div class="btn"></div></a>
</div>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $(".dc_tit1").animate({
          left:87+'vw'
          },1500);
});
</script>
<script language="javascript" type="text/javascript">
document.getElementById("gif").src="/Public/img/animate_bg.gif?"+Math.random();
</script>
<!--百度联盟//-->
<script type="text/javascript">
    /*手机源码演示页面*/
    var cpro_id = "u2160319";
</script>

</body>

</html>