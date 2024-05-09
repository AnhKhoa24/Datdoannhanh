var matinh = 79;
var maqh = -1;
$(document).ready(function () {
    $("#select-tinh").select2({
        ajax: {
            url: "/get-tinh",
            type: "post",
            delay: 250,
            dataType: 'json',
            data: function (params) {
                return {
                    search: params.term,
                    "_token": csrfToken,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.code,
                            text: item.full_name,
                        };
                    })
                };

            },
        },
        data: [{
            id: 79,
            text: 'Thành Phố Hồ Chí Minh',
            selected: true
        }],
        placeholder: "Chọn tỉnh",
        // allowClear: true,
        language: "es"
    });
});
$(document).ready(function () {
    $("#select-qh").select2({
        ajax: {
            url: "/get-qh",
            type: "post",
            delay: 250,
            dataType: 'json',
            data: function (params) {
                return {
                    search: params.term,
                    ma_tinh: matinh,
                    "_token": csrfToken,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.code,
                            text: item.full_name,
                        };
                    })
                };

            },
        },
        placeholder: "Chọn quận/huyện",
        language: "es"
    });
});
$(document).ready(function () {
    $("#select-px").select2({
        ajax: {
            url: "/get-px",
            type: "post",
            delay: 250,
            dataType: 'json',
            data: function (params) {
                return {
                    search: params.term,
                    ma_qh: maqh,
                    ma_tinh: matinh,
                    "_token": csrfToken,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.code,
                            text: item.full_name,
                        };
                    })
                };

            },
        },
        placeholder: "Chọn quận/huyện",
        language: "es"
    });
});

function chonTinh() {
    var selectElement = document.getElementById('select-tinh');
    matinh = selectElement.value;
    maqh = -1;
    $("#select-qh").empty();
    $("#select-px").empty();

}

function chonQH() {
    var selectElement = document.getElementById('select-qh');
    maqh = selectElement.value;
    $("#select-px").empty();
}

function chonPX() {
    var selectElement = document.getElementById('select-px');
    var pxval = parseInt(selectElement.value);
    $.ajax({
        url: "/get-px",
        type: "post",
        delay: 250,
        dataType: 'json',
        data: {
            pxval: pxval,
            "_token": csrfToken
        },
        success: function (data) {
            if (data.district_code != maqh) {
                $("#select-qh").select2({
                    ajax: {
                        url: "/get-qh",
                        type: "post",
                        delay: 250,
                        dataType: 'json',
                        data: function (params) {
                            return {
                                search: params.term,
                                ma_tinh: matinh,
                                "_token": csrfToken,
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        id: item.code,
                                        text: item.full_name,
                                    };
                                })
                            };

                        },
                    },
                    data: [{
                        id: data.code,
                        text: data.full_name,
                        selected: true
                    }],
                    placeholder: "Chọn quận/huyện",
                    language: "es"
                });
            }
        },
    });
}
function dathang(event) {
    event.preventDefault();
    var mapx = document.getElementById('select-px').textContent.trim();
    var tinh = document.getElementById('select-tinh').textContent.trim();
    var huyen = document.getElementById('select-qh').textContent.trim();
    var recipient_name = document.getElementById('name').value;
    var recipient_phone = document.getElementById('phone').value;
    var recipient_address = document.getElementById('address').value;
    var note = document.getElementById('note').value;
    if (mapx == '' || recipient_name == "" || recipient_phone == "" || recipient_address == "" || tinh == "" || huyen == "") {
        swal({
            title: "Khoan đã!",
            text: "Bạn đã điền thiếu thông tin!",
            icon: "warning",
            button: "Biết rồi!",
        });
        return;
    }

    var address = recipient_address + ", " + mapx + ", " + huyen + ", " + tinh;

    console.log(address);
    var selectedPayment = document.querySelector('input[name="payment"]:checked');
    if (selectedPayment) {
        var paymentContent = selectedPayment.nextElementSibling.textContent.trim();
    } else {
        swal({
            title: "Khoan đã!",
            text: "Vui lòng chọn phương thức thanh toán!",
            icon: "warning",
            button: "Biết rồi!",
        });
        return;
    }

    swal({
        title: 'Đang xử lý...',
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        onOpen: () => {
            swal.showLoading();
        }
    });

    $.ajax({
        url: "/checkout",
        type: "post",
        delay: 250,
        dataType: 'json',
        data: {
            "_token": csrfToken,
            name: recipient_name,
            phone: recipient_phone,
            address: address,
            note: note,
            payment: paymentContent,
        },
        success: function (data) {
            if (data == 1) {
                swal.close();
                swal({
                    title: 'Thành công!',
                    text: 'Đặt hàng thành công!',
                    icon: 'success',
                }).then((value) => {
                    if (value) {
                        window.location.href = "/donhang";
                    }
                });
            } else {
                swal.close();
                swal({
                    title: 'Thất bại!',
                    text: 'Đơn hàng của bạn chã có gì!',
                    icon: 'warning',
                }).then((value) => {
                    if (value) {
                        window.location.href = "/";
                    }
                });
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal.close();
            swal({
                title: 'Lỗi!',
                text: 'Đã xảy ra lỗi khi đặt hàng!',
                icon: 'error',
            });
        }
    })
}