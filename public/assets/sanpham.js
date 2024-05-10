$(document).ready(function () {
    $('#testti').select2();
    $("#testti").select2({
        ajax: {
            url: "/admin/laydanhmuc",
            type: "post",
            delay: 250,
            dataType: 'json',
            data: function (params) {
                return {
                    name: params.term,
                    "_token": csrfToken,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.ma_danhmuc,
                            text: item.tendanhmuc,
                        };
                    })
                };

            },
        },
        data: $.map(danhmuc, function (option) {
            return {
                id: option.ma_danhmuc,
                text: option.tendanhmuc,
                selected: true
            };
        })
    })
});

document.getElementById("submitBtn").addEventListener("click", function(e) {
    e.preventDefault();
    validateForm();
    if (validateForm()) {
        var loadingAlert = swal({
            title: "Loading...",
            text: "Please wait",
            icon: "info",
            buttons: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
        });
        $('#myForm').append('<input type="hidden" name="_token" value="' + csrfToken + '">');
        var formData = new FormData($('#myForm')[0]);
        $.ajax({
            type: 'POST',
            url: '/admin/sanpham-them',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                swal.close();
                swal("Thành công!", "Bạn đã thêm thành công sản phẩm mới!", "success").then((value) => {
                    window.location.href = "/admin/sanpham";
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                swal.close();
                swal("Error!", "An error occurred. Please try again later.", "error");
            }
        });

    }
});


function validateForm() {
    var productName = document.getElementById("product_name").value;
    var price = document.getElementById("price").value;
    var category = document.getElementById("testti").value;

    var productNameError = document.getElementById("check-product_name");
    var priceError = document.getElementById("check-price");
    var categoryError = document.getElementById("check-danhmuc");

    var isValid = true;

    if (productName.trim() === '') {
        productNameError.textContent = "Vui lòng nhập tên sản phẩm.";
        isValid = false;
    } else {
        productNameError.textContent = "";
    }

    if (price.trim() === '') {
        priceError.textContent = "Vui lòng nhập giá sản phẩm.";
        isValid = false;
    } else {
        priceError.textContent = "";
    }

    if (category.trim() === '') {
        categoryError.textContent = "Vui lòng chọn danh mục sản phẩm.";
        isValid = false;
    } else {
        categoryError.textContent = "";
    }

    return isValid;
}

function xoaSP(product_id) {
    swal({
        title: "Bạn muốn xóa?",
        text: "Bạn có chắc muốn xóa đi sản phẩm này không!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "/admin/sanpham-xoa",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        product_id: product_id,
                        "_token": csrfToken,
                    },
                    success: function (response) {
                        if (response == 1) {

                            swal("Keeee! Bạn đã xóa thành công!", {
                                icon: "success",
                            }).then((value) => {
                                // Nếu swal đã được đóng
                                if (value) {
                                    // Điều hướng sau khi swal đã được hiển thị
                                    window.location.href = "/admin/sanpham";
                                }
                            });
                        }
                        else if (response == 0)
                        {
                            swal("Thất bại! Sản phẩm vẫn còn tồn tại trong đơn hàng!", {
                                icon: "warning",
                            })
                        }

                    },
                    error:function()
                    {
                        swal("Lỗi! Lỗi server vui lòng thử lại sau!", {
                            icon: "error",
                        })
                    }
                })

            }
        });

}
