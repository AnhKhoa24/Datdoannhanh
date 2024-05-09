function huydonhang(order_id) {
    swal({
            title: "Hủy đơn hàng?",
            text: "Bạn có chắc muốn hủy đơn hàng này không!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "/admin/huydonhang",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        order_id: order_id,
                        "_token": csrfToken,
                    },
                    success: function(data) {
                        swal("Thành công! Bạn đã hủy đơn hàng thành công!", {
                            icon: "success",
                        }).then((value) => {
                            if (value) {
                                window.location.href = "/admin/donhang";
                            }
                        });
                    },
                    error: function() {
                        swal("Lỗi!", "Đã có lỗi xảy ra. Vui lòng thử lại sau.", "error");
                    }
                });
            }
        });
}

function Loadgia(event, order_id, product_id) {
    if (event.key === "Enter") {
        var soluong = document.getElementById('doi-soluong_' + product_id).value;
        var by_price = document.getElementById('gia-goc_' + product_id).value;
        var total = parseInt(soluong) * parseInt(by_price);
        $.ajax({
            url: "/doisoluong",
            type: 'POST',
            dataType: "json",
            data: {
                product_id: product_id,
                order_id: order_id,
                quantity: soluong,
                total: total,
                "_token": csrfToken,
            },
            success: function(data) {
                var totaltext = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                document.getElementById('total-doi_' + product_id).innerHTML = totaltext + "đ";
            },
            error: function() {

            }
        });
    }
}

function SaveI4() {
    var status = document.getElementById('inp-status').value;
    var recipient_name = document.getElementById('inp-recipient_name').value;
    var recipient_phone = document.getElementById('inp-recipient_phone').value;
    var recipient_address = document.getElementById('inp-recipient_address').value;
    var payment = document.getElementById('inp-payment').value;
    var order_id = document.getElementById('inp-order_id').value;
    swal({
        title: "Đang xử lý...",
        text: "Vui lòng đợi trong giây lát",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
    });
    $.ajax({
        url: "/admin/donhang-savechages",
        type: "POST",
        delay: 250,
        data: {
            "_token": csrfToken,
            status: status,
            recipient_name: recipient_name,
            recipient_phone: recipient_phone,
            recipient_address: recipient_address,
            payment: payment,
            order_id: order_id,
        },
        success: function(response) {

            swal.close();
            swal({
                title: 'Thành công!',
                text: 'Cập nhật thành công thông tin đơn hàng!',
                icon: 'success',
            })
        },
        error: function() {
            swal.close();
            swal("Lỗi!", "Đã có lỗi xảy ra. Vui lòng thử lại sau.", "error");
        }
    });
}