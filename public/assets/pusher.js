// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('ea6012be0da9b8704099', {
    cluster: 'ap1'
});

// var channel = pusher.subscribe('khoaday');
// channel.bind('khoaday', function(data) {
//     // alert(JSON.stringify(data));

//     var toast = document.querySelector('.bs-toast');
//     if (toast) {
//         toast.classList.remove('hide');
//         toast.classList.add('show');
//         document.getElementById('thongbao-realtime').innerHTML = data.thongbao;
//     }

// });
var channel = pusher.subscribe('khoalatui');
channel.bind('khoalatui', function(data) {
    var toast = document.querySelector('.bs-toast');
    if (toast) {
        toast.classList.remove('hide');
        toast.classList.add('show');
        document.getElementById('thongbao-realtime').innerHTML = data.message;
    }
});