$(document).ready(function(){
    $('#testti').select2();
    $("#testti").select2({
        ajax: {
            url: "/admin/laydanhmuc",
            type: "post",
            delay: 250,
            dataType: 'json',
            data: function(params) {
                return {
                    name: params.term,
                    "_token": csrfToken,
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.ma_danhmuc,
                            text: item.tendanhmuc,
                        };
                    })
                };

            },
        },
        data: $.map(danhmuc, function(option) {
            return {
                id: option.ma_danhmuc,
                text: option.tendanhmuc,
                selected: true
            };
        })
    })
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
        categoryError.textContent = ""  ;
    }

    return isValid;
}
