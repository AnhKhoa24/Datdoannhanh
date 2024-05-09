Pusher.logToConsole = true;
var pusher = new Pusher('ea6012be0da9b8704099', {
    cluster: 'ap1'
});
var channel = pusher.subscribe('khoalatui');
channel.bind('khoalatui', function(data) {
    if (user_id != data.user_id) {
        //Realtime sản phẩm
        if (isScriptLoaded('assets/ptsanpham.js')) {
            var sotrang = laysotrang();
            getData(sotrang);
        }
        var toast = document.querySelector('.bs-toast');
        if (toast) {
            toast.classList.remove('hide');
            toast.classList.add('show');
            document.getElementById('thongbao-realtime').innerHTML = data.message;
        }

    }
});
var channel = pusher.subscribe('huydon');
channel.bind('huydon', function(data) {
    //Realtime yeucauhuydon
    if (isScriptLoaded('assets/yeucauhuydon.js')) {
            var sotrang = laysotrang();
            getData(sotrang);
        }
    var toast = document.querySelector('.bs-toast');
    if (toast) {
        toast.classList.remove('hide');
        toast.classList.add('show');
        document.getElementById('thongbao-realtime').innerHTML = data.message;
    }
});

// Kiểm tra xem một tệp JS đã được liên kết thành công hay không
function isScriptLoaded(url) {
    var scripts = document.getElementsByTagName('script');
    for (var i = 0; i < scripts.length; i++) {
        if (scripts[i].src && scripts[i].src.includes(url)) {
            return true;
        }
    }
    return false;
}