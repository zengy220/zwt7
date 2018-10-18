//生成n位随机数
function random(n) {
    //初始化参数
    var rnd = "";
    for (var i = 0; i < n; i++) {
        rnd += Math.floor(Math.random() * 10);
    }
    return rnd;
}

function getHsonLength(json) {
    var jsonLength = 0;
    for (var i in json) {
        jsonLength++;
    }
    return jsonLength;
}