function danhgia(product_id) {
    var sle = document.querySelector('.stars input[name="rating"]:checked');
    if (sle == null) {
        swal("Haizz!", "Vui lòng chọn số sao!", "warning");
        return;
    }
    var selectedRating = sle.value;
    var name = document.getElementById("dg-name").value;
    var content = document.getElementById("dg-content").value;
    $.ajax({
        url: "/danhgia",
        type: 'POST',
        dataType: "json",
        data: {
            product_id: product_id,
            sosao: selectedRating,
            name: name,
            content: content,
            "_token": csrfToken,
        },
        success: function (data) {
            getRR(product_id);
        },
        error: function () {

        }
    });
}

function getRR(product_id) {
    $.ajax({
        url: "/chitiet/" + product_id,
        type: 'GET',
        dataType: "json",
        success: function (data) {
            $('#area-rating').empty().html(data.loadrate);
            $('#area-review').empty().html(data.loadreview);
            $('#area-reform').empty().html(data.loadreform);
            $('#area-freview').empty().html(data.loadfre);
        },
        error: function () { }
    });
}

function themgiohang(product_id) {
    if (typeof user_id === 'undefined') {
        window.location = "/login";
        return;
    }
    var quantity = document.getElementById('inp-quantity').value;
    $.ajax({
        url: "/add-to-cart",
        type: 'POST',
        dataType: "json",
        data: {
            product_id: product_id,
            quantity: quantity,
            "_token": csrfToken,
        },
        success: function (data) {
            $("#minicart").empty().html(data.giohang);
            swal("Thành công!", "Bạn đã thêm thành giỏ hàng!", "success")
        },
        error: function () {

        }
    });
}