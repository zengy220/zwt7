// 初始化MUI 
mui.init({
    swipeBack: false
});
(function($) {
    $('.mui-scroll-wrapper').scroll({
        indicators: true //是否显示滚动条
    });
    var html2 = '';
    var html3 = '';
    var item2 = document.getElementById('item2mobile');
    var item3 = document.getElementById('item3mobile');
    document.getElementById('slider').addEventListener('slide', function(e) {
        if (e.detail.slideNumber === 1) {
            if (item2.querySelector('.mui-loading')) {
                setTimeout(function() {
                    item2.querySelector('.mui-scroll').innerHTML = html2;
                }, 500);
            }
        } else if (e.detail.slideNumber === 2) {
            if (item3.querySelector('.mui-loading')) {
                setTimeout(function() {
                    item3.querySelector('.mui-scroll').innerHTML = html3;
                }, 500);
            }
        }
    });
})(mui);

// 直播的气泡
var demo2 = new JumpBubble({
    elCanvas: document.getElementById("myCanvas"),
    config: {
        alpha: 0.5,
        width: 30
    },
    callback: function(a, b, c) {}
});
clearInterval(setDemo2);
var setDemo2 = setInterval(function() {
    demo2.create({
        elImg: document.getElementById("img2")
    });
}, 500);

//  渲染之后才能获取到结构的高度 高度通过js 计算
// 判断登页面资源加载之后 执行
setTimeout(function() {
    var h = document.documentElement.clientHeight || document.body.clientHeight;
    var h1 = $(".video1").height();
    var h2 = $(".icons").height();
    var h3 = $(".mui-control-item").height();
    console.log(h1 + "---------" + h2 + "-------" + h3 + "---------" + h);
    var h4 = h - h1 - h2 - h3;
    console.log(h4);
    // $(".txtContent").css('height', h4);
    $('.mui-control-content').css('height', h4);
    moving();
    // x5-video-player-type="h5" x5-video-player-fullscreen="true"
    //  webkit-playsinline="true" x-webkit-airplay="true"
    // playsinline
    $('video').attr('x5-video-player-type', 'h5');
    $('video').attr('x5-video-player-fullscreen', true);
    $('video').attr('webkit-playsinline', true);
    $('video').attr('x-webkit-airplay', true);
    $('video').attr('playsinline');

    // 操作video  标签  
    var iWindowWidth;
    var iWindowHeight;
    window.onresize = function() {
        // autoWH();
        myPlayer.style.width = iWindowWidth + "px";
        myPlayer.style.height = iWindowHeight + "px";
    };
    //获取videojs生成的video
    var myPlayer = $('video');
    //播放按钮
    // var oPlayBtn = document.getElementById("playBtn");
    //获取视频盒子
    var oVideoBox = document.getElementById("countdown");
    //获取滚动盒子
    // var oScrollBox = document.getElementById("item1mobile");
    //遮罩图片
    var oPoster = $('.box').find('img');
    // var oScroll = document.getElementById("scroll");
    //图片加载完
    oPoster.onload = function() {
        oVideoBox.style.height = oPoster.offsetHeight + "px";
    };
    // var fScroll = new iScroll(oScrollBox, {
    //     hScrollbar: false,
    //     vScrollbar: false,
    //     bounce: false
    // });
    window.addEventListener('touchmove', function(e) {
        e.preventDefault();
    }, false);

    // function autoWH() {
    //     //获取可视区宽度
    //     iWindowWidth = window.innerWidth;
    //     //获取可视区高度
    //     iWindowHeight = window.innerHeight;
    //     var iScrollH = 3 * iWindowWidth / 4;
    //     oScrollBox.style.top = iScrollH + "px";
    //     oScrollBox.style.height = iWindowHeight - iScrollH + "px";
    //     fScroll.refresh();
    // }
    // autoWH();

    // 存在就绑定
    if ($('video')[0]) {
        $('video')[0].addEventListener("x5videoexitfullscreen", function() {
            // alert("exit fullscreen");
            // $('video').play();
            // $('#box').css('display', "none");
        })
        $('video')[0].addEventListener("x5videoenterfullscreen", function() {
            // alert("enter fullscreen");
            // $('#box').css('display', "block");
        })
    }
}, 300);


// JS代码：用JS代码自动判断窗口的高度，然后赋值给body。
$(document).ready(function() {
    $('body').css({
        'height': $(window).height()
    })
});

//  消息滚动
function moving() {

    // var chatlist = document.getElementById('ulList');
    // chatlist.scrollTop = chatlist.scrollHeight;

    var ulH = $('#ulList').css('height');
    var mH = $('#item1mobile').css('height');
    console.log(ulH);
    console.log(mH);
    // 判断高度是否滚动
    if (ulH > mH) {
        var disH = parseInt(ulH) - parseInt(mH) + 65;
        console.log(disH);
        $('.mui-scroll').css('transform', 'translate3d(0px,-' + disH + 'px,0px)');
    }

}

// countTime();

function countTime() { //获取当前时间               
    var date = new Date();
    var now = date.getTime();
    //设置截止时间  
    var str = "2018/03/10 10:18:00";
    var endDate = new Date(str);
    var end = endDate.getTime();

    //时间差   判断时间差如果为负数 则表示正在直播中
    var leftTime = end - now;
    //定义变量 d,h,m,s保存倒计时的时间  
    var d, h, m, s;
    if (leftTime >= 0) {
        d = Math.floor(leftTime / 1000 / 60 / 60 / 24);
        h = Math.floor(leftTime / 1000 / 60 / 60 % 24) > 10 ? Math.floor(leftTime / 1000 / 60 / 60 % 24) : 0 + '' + Math.floor(leftTime / 1000 / 60 / 60 % 24);
        m = Math.floor(leftTime / 1000 / 60 % 60) > 10 ? Math.floor(leftTime / 1000 / 60 % 60) : 0 + '' + Math.floor(leftTime / 1000 / 60 % 60);
        s = Math.floor(leftTime / 1000 % 60);
    }
    //将倒计时赋值到div中  
    var box = document.getElementById('txtP'); // 提示文字的容器
    // 判断 如果 d 数为零 则不显示 天数
    if (d == 0) {
        document.getElementById('countTimes').innerHTML = h + "时" + m + "分" + s + "秒";
    } else if (d > 0) {
        document.getElementById('countTimes').innerHTML = d + "天" + h + "时" + m + "分" + s + "秒";
    } else {
        box.innerText = "正在直播中....";
    }
    if (d == 0 && h == 0 && m == 0 && s == 0) {
        box.innerText = "正在直播中....";
    } else {
        setTimeout(countTime, 1000);
    }

}