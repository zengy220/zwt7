(function() {
    var option = {
        "channel_id": "10905947996256317687",
        "app_id": "1255946259",
        "width": "640",
        "height": "380",
        "h5_start_patch": {
            url: "./img/cover.png",
            stretch: true
        },
        'x5_fullscreen': false,
    };
    var listener = {
        'playStatus': function(status, type) {
            // alert(status);
            if (status == 'playing') {
                // alert(status)
                console.log(status);
                $('.countdown').css('display', 'none');
            }
            if (status == 'ready') {
                // play();
                console.log(status);
            }
            if (status == 'playEnd') {
                // play();
                // alert("playEnd");
                // 直播结束 提示信息弹出
                $("#tip").css('display', 'block');
                console.log(status);
            }
            if (status == "error") {
                // alert("error");
                // 直播发生异常  无法播放提示直播结束
                $("#tip").css('display', 'block');
                console.log(status);
                console.log(type);
            }
            // 报错的时候  type 会返回错误类型
            // alert(type);
        }
    }
    var obj = new qcVideo.Player("id_video_container_10905947996256317687", option, listener);
    console.log(obj);
    // var barrage = {
    //     "type": "content", //消息类型，content：普通文本（必选） 
    //     "content": "hello world asdfasdf asdfa sdfasdfa dsfa sdf asdfasdderqwerqweasdgasdg", //文本消息（必选） 
    //     "time": "1.101", //单位秒 ，表示距离当前调用添加字幕的时间多久后，开始显示该条字幕（必选） 
    //     "style": "C64B03;35", // 分号分割，第一项颜色值，第二项字体大小（可选）
    //     "postion": "up" //固定位置  // center: 居中， bottom: 底部， up: 顶上(可选)
    // };
    // obj.addBarrage(barrage);
})();