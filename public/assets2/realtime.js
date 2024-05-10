Pusher.logToConsole = true;

var pusher = new Pusher('ea6012be0da9b8704099', {
    cluster: 'ap1'
});
var channel = pusher.subscribe('thongbaoclient');
channel.bind('thongbaoclient', function (data) {
    if (data.assets['user_id'] == user_id) {
        getMesage();
        showNotification(data.message);
        if (data.assets['status'] && data.assets['status'] == -1) {
            var xoaall = document.getElementById("item-order_"+data.assets['order_id']);
            var xoahr = document.getElementById("hr_"+data.assets['order_id']);
            if(xoaall && xoahr){
                xoaall.remove();
                xoahr.remove();
            }   
        }
        if (data.assets['status'] && data.assets['status'] < 6 && data.assets['status'] > 0) {
            var doitrangthai = document.getElementById("doitrangthai-header");
            if (doitrangthai) {
                doitrangthai.innerText = "Mã đơn: " + data.assets['order_id'] + " || Trạng thái: " + data.assets['trangthai'];
            }
        }
        if (data.assets['status'] && data.assets['status'] == 6) {
            var xoaall = document.getElementById("item-order_"+data.assets['order_id']);
            var xoahr = document.getElementById("hr_"+data.assets['order_id']);
            if(xoaall && xoahr){
                xoaall.remove();
                xoahr.remove();
            }   
        }
       
    }
});
function showNotification(content) {

    $("#notif-content").empty().html(content);
    var notification = document.getElementById("notification");
    notification.style.display = "block";
    notification.classList.add("show");
    setTimeout(function () {
        hideNotification();
    }, 3000);
}
function hideNotification() {
    var notification = document.getElementById("notification");
    notification.classList.remove("show"); 
    setTimeout(function () {
        notification.style.display = "none";
    }, 1000); 
}