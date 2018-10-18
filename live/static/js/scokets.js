 // 链接到服务器
 //  测试环境
 //  ws = new WebSocket("ws://192.168.0.153:2346");
 // 正式环境
 ws = new WebSocket("ws://218.77.55.3:8093");

 // 检测心跳包
 var heartCheck = {
         timeout: 20000, //60s
         timeoutObj: null,
         reset: function() {

             clearTimeout(this.timeoutObj);　　　　
             this.start();

         },
         start: function() {

             this.timeoutObj = setTimeout(function() {
                 //发送心跳包
                 console.log("发送心跳包");
                 var SendData = new Object();
                 SendData.Mode = 12;
                 SendData.userid = userid;
                 SendData.username = username;
                 SendData.XM = XM;
                 SendData = JSON.stringify(SendData);
                 ws.send(SendData);

             }, this.timeout)

         }
     }
     //关闭
 ws.onclose = function() {
     console.log("关闭");
     reconnect();
     //return; 
 };
 //错误
 ws.onerror = function() {
     console.log("服务器维护中...");
     reconnect();
     //return;     
 };
 // 连接操作 调用ws的方法
 ws.onopen = function() {
     //  console.log("客户端请求连接！");
     var userid = sessionStorage.getItem("userid");
     if (userid == "" || userid == null) {
         console.log("暂未登录");
         var randid = random(15); //生成n为随机数
         var userid = randid;
         var username = "U" + randid;
         var XM = '游客U' + randid;
         //  修改姓名后 存储session  判断是否存在 并赋值
         var Localsm = sessionStorage.getItem("XM");
         console.log(Localsm);
         if (Localsm != null) {
             XM = Localsm;
         }
         //  游客不能发言
         $("#msg").attr('placeholder', "");
         //  游客提示信息层显示
         $('.ceng').css('display', 'block');
         $('#msg').attr('readonly', "readonly");
         //  发送按钮变灰色 禁止点击
         $('#send').css('backgroundColor', "#999");
         $('#send').attr('disabled', true);

         //  显示修改昵称的按钮
         $('#changeName').css('display', "block");

     } else {
         console.log("已登录");
         var userid = sessionStorage.getItem("userid");
         var username = sessionStorage.getItem("username");
         var XM = sessionStorage.getItem("XM");
     }

     //记录访问信息
     var SendData = new Object();
     SendData.Mode = 1;
     SendData.username = username;
     SendData = JSON.stringify(SendData);
     ws.send(SendData);

     //注册在线信息
     var SendData2 = new Object();
     SendData2.Mode = 4;
     SendData2.userid = userid;
     SendData2.username = username;
     SendData2.XM = XM;
     SendData2 = JSON.stringify(SendData2);
     ws.send(SendData2);

     //获取在线信息
     var SendData3 = new Object();
     SendData3.Mode = 5;
     SendData3 = JSON.stringify(SendData3);
     ws.send(SendData3);

     //广播
     var SendData4 = new Object();
     SendData4.Mode = 6;
     SendData4.msg = '<span>【系统消息】</span><span style="color:#F00;">' + XM + "</span>来啦！";
     SendData4 = JSON.stringify(SendData4);
     ws.send(SendData4);
     //  屏幕滚动   每发生一次广播 就调用一次  滚动屏幕
     moving();
     //获取点赞数
     var SendData5 = new Object();
     SendData5.Mode = 9;
     SendData5 = JSON.stringify(SendData5);
     ws.send(SendData5);

     //获取禁言开关状态
     var SendData6 = new Object();
     SendData6.Mode = 10;
     SendData6 = JSON.stringify(SendData6);
     ws.send(SendData6);
 };

 //交互信息回调函数

 ws.onmessage = function(e) {
     //  console.log("服务端消息：" + e.data);
     var returndata = e.data;
     var obj = JSON.parse(returndata); //由JSON字符串转换为JSON对象
     var Mode = obj.mode;
     var Code = obj.code;
     var Msg = obj.msg;
     console.log(obj);
     if (Mode == 2) //登录 注册信息
     {
         console.log(Code + "*****" + Mode);
         var userid = obj.data.id;
         var username = obj.data.username;
         var XM = obj.data.XM;
         // 注册session    
         sessionStorage.setItem("userid", userid);
         sessionStorage.setItem("username", username);
         sessionStorage.setItem("XM", XM);
         console.log("登录注册：" + username);
     }
     if (Mode == 3) //发布留言
     {
         var message = obj.data;
         console.log(Code + "*****" + Mode);
         console.log("发布留言：" + message);
         if (Code != 1) {
             //  禁言状态
             mui.toast('您当前为禁言状态', {
                 duration: 'long',
                 type: 'div'
             });
         } else {
             //广播留言   给所有的在线用户
             var XM = sessionStorage.getItem('XM');
             var SendData2 = new Object();
             SendData2.Mode = 6;
             SendData2.msg = '<span style="color:#F00;">' + XM + ":</span>" + message;
             SendData2 = JSON.stringify(SendData2);
             ws.send(SendData2);
         }
         // 如果是禁止发言的状态不能发送留言
         //  设置一个标签 如果为禁言 则不能发言  不广播
     }

     if (Mode == 4) { // 注册在线的信息
         console.log(Code + "*****" + Mode);
     }

     if (Mode == 5) //在线用户
     {
         console.log(Code + "*****" + Mode);
         var userlist = obj.data;
         //  console.log(userlist);
         var num = getHsonLength(userlist);
         var content = "共有" + num + "人在线";
         document.getElementById('num1').innerHTML = num;
         //  console.log("在线用户" + userlist);
     }

     if (Mode == 6) { // 广播留言
         //  进来就会广播留言  某某来了
         //  如果是禁言状态则不能发出广播
         //  判断个人是否被禁言
         var message = obj.data;
         var li = document.createElement('li');
         var p = document.createElement('p');
         p.innerHTML = message;
         li.appendChild(p);
         document.getElementById('ulList').appendChild(li);
         //  屏幕滚动
         moving();
         console.log("广播留言：" + message);
     }
     if (Mode == 9) //点赞数
     {
         var tol = obj.data;
         //  var content = "共有" + tol + "人点赞";
         document.getElementById('num2').innerHTML = tol;
         //  屏幕滚动
         moving();
         console.log("点赞数" + tol);
     }
     if (Mode == 10) //房间禁言状态
     {
         // 屏幕滚动
         moving();
         var status = obj.data;

         //  获取到session
         var user = sessionStorage.getItem("userid");
         //  console.log(sm);
         if (status == 1) {
             //   可以聊天
             //  判断是否是游客
             if (user == null || "") {
                 $("#msg").attr('placeholder', "");
                 $('#msg').attr('readonly', "readonly");
                 $('.ceng').css('display', 'block');
                 //  发送按钮变灰色 禁止点击
                 $('#send').css('backgroundColor', "#999");
                 $('#send').attr('disabled', true);
                 $(".ceng").find('p').html('<a style="color:orangered;" href="./login.html">登录</a> &nbsp;后可以发言');
             } else {
                 $('.ceng').css('display', 'none');
                 $("#msg").attr('placeholder', "说点什么");
                 $('#msg').attr('readonly', false);
                 //  发送按钮变灰色 
                 $('#send').css('backgroundColor', "#FE7D06");
                 $('#send').attr('disabled', false);
             }

         } else {
             // 不可聊天
             //  禁言状态
             mui.toast('当前房间为禁言状态', {
                 duration: 'long',
                 type: 'div'
             });
             if (user == null || "") {
                 //  游客
                 $("#msg").attr('placeholder', "");
                 $('#msg').attr('readonly', "readonly");
                 $('.ceng').css('display', 'block');
                 //  发送按钮变灰色 禁止点击
                 $('#send').css('backgroundColor', "#999");
                 $('#send').attr('disabled', true);
                 $(".ceng").find('p').html('<a style="color:orangered;" href="./login.html">登录</a> &nbsp;后可以发言');
             } else {
                 // 禁止在线用户聊天
                 //  游客不能发言
                 $("#msg").attr('placeholder', "");
                 $('.ceng').css('display', 'block');
                 $('#msg').attr('readonly', "readonly");
                 //  发送按钮变灰色 禁止点击
                 $('#send').css('backgroundColor', "#999");
                 $('#send').attr('disabled', true);
                 $(".ceng").find('p').html('当前房间为禁言状态');
             }

         }
     }
     if (Mode == 11) {
         //  $('.userList').find('li').eq(2).AllnextSbiling('li').remove();
     }
     if (Mode == 12) //心跳包检测
     {
         var userid = obj.data;
         console.log("心跳包检测:" + userid);
         if (userid == "" || userid == null) {
             console.log("心跳重连中...");
             reconnect();
         }
     }
     //  屏幕滚动
     moving();
 };
 // 登录
 //  function login() {
 //      console.log("客户端发起登录");
 //      var username = document.getElementById("username").value;
 //      var password = document.getElementById("password").value;
 //      if (username == '' || password == '') {
 //          console.log("用户名或密码不能为空！");
 //          mui.toast('用户名或密码不能为空！', { duration: 'short', type: 'div' });
 //          return;
 //      }
 //      var MsgData = new Object();
 //      MsgData.Mode = 2;
 //      MsgData.Username = username;
 //      MsgData.Password = password;
 //      MsgData = JSON.stringify(MsgData);
 //      ws.send(MsgData);
 //      window.location.href = "./test.html";

 //  }


 // send 向服务器发送信息
 function send() {
     var userid = sessionStorage.getItem("userid");
     var username = sessionStorage.getItem("username");
     var XM = sessionStorage.getItem("XM");
     if (userid == '' || userid == null) {
         console.log("游客无法发言！");
         mui.toast('游客不能发言', { duration: 'short', type: 'div' });
         return;
     }
     //  console.log("客户端发送新留言");
     var msg = document.getElementById("msg").value;
     //  判断文本框不能为空
     if (msg == "") {
         mui.toast('消息不能为空', { duration: 'short', type: 'div' });
         return;
     }
     var tousername = "ALL"; // 给所有的用户广播

     //  信息留言
     var MsgData = new Object();
     MsgData.Mode = 3;
     MsgData.Data = msg;
     MsgData.Username = username;
     MsgData.ToUsername = tousername;
     MsgData = JSON.stringify(MsgData);
     ws.send(MsgData);
     //  清空文本框
     $(".information").val("");
 }

 // 点赞函数
 function dz() {
     console.log("客户端发起点赞");
     var userid = sessionStorage.getItem("userid");
     var username = sessionStorage.getItem("username");
     var XM = sessionStorage.getItem("XM");
     if (XM == null) {
         XM = '游客';
     }
     if (userid == '' || userid == '') {
         console.log("userid不能为空！");
         //  alert("userid不能为空！");
         return;
     }
     var MsgData = new Object();
     MsgData.Mode = 8;
     MsgData.userid = userid;
     MsgData.username = username;
     MsgData = JSON.stringify(MsgData);
     ws.send(MsgData);

     //广播
     var SendData2 = new Object();
     SendData2.Mode = 6;
     SendData2.msg = '<span style="color:#F00;">' + XM + ':</span>给了一个赞！';
     SendData2 = JSON.stringify(SendData2);
     ws.send(SendData2);

     //获取点赞数
     var SendData5 = new Object();
     SendData5.Mode = 9;
     SendData5 = JSON.stringify(SendData5);
     ws.send(SendData5);
 }
 // 重新链接的函数
 function reconnect() {
     //重连
     location.reload();
 }

 //  游客修改昵称
 //  function changeName() {
 document.getElementById("changeName").addEventListener('tap', function(e) {
     console.log("客户端发起修改昵称");
     //  if (e.detail) {
     e.detail.gesture.preventDefault(); //修复iOS 8.x平台存在的bug，使用plus.nativeUI.prompt会造成输入法闪一下又没了
     //  }
     var btnArray = ['取消', '确定'];
     mui.prompt('请输入您想要的昵称：', '', "游客可修改昵称", btnArray, function(e) {
         if (e.index == 1) {
             //  info.innerText = '谢谢你的评语：' + e.value;
             //  注册session  修改用户的XM
             sessionStorage.setItem("XM", e.value + "(游客)");
             //和服务端交互
             var MsgData = new Object();
             MsgData.Mode = 8;
             MsgData.userid = "userid";
             MsgData.username = "username";
             MsgData = JSON.stringify(MsgData);
             ws.send(MsgData);
             mui.toast('修改成功！', { duration: 500, type: 'div' });
             //  window.location.reload();
             setTimeout(function() { window.location.reload(); }, 500);

         } else {
             //  info.innerText = '你点了取消按钮';
             mui.toast('你点了取消按钮', { duration: 500, type: 'div' });
         }
     })
 });
 //  }