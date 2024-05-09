var ngaydef = "";
var trangthaidef = "";
function Duyet(order_id, status) {
    swal({
        title: "Đang xử lý...",
        text: "Vui lòng đợi trong giây lát",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
    });
    $.ajax({
        url: "/admin/donhang/duyetnhanh",
        type: "POST",
        delay: 250,
        data: {
            "_token": csrf,
            order_id: order_id,
            status: status,
        },
        success: function (response) {
            var change = document.getElementById("status_" + order_id);
            if (response == 2) {
                change.innerHTML = `
                <button type="button" onclick="Duyet(${order_id},${response})" class="btn btn-primary">Chuẩn bị hàng</button>
            `;
            }
            if (response == 3) {
                change.innerHTML = `
                <button type="button" onclick="Duyet(${order_id},${response})" class="btn btn-primary">Chuẩn bị xong</button>
            `;
            }
            if (response == 4) {
                change.innerHTML = `
                <button type="button" onclick="Duyet(${order_id},${response})" class="btn btn-primary">Giao hàng</button>
            `;
            }
            if (response == 5) {
                change.innerHTML = `
                <button type="button" onclick="Duyet(${order_id},${response})" class="btn btn-primary">Đã giao</button>
            `;
            }
            if (response == 6) {
                change.innerHTML = ` <span class="badge bg-success">Đơn hàng đã giao thành công!</span>`;
            }
            swal.close();
            swal("Thành công", "Trạng thái đơn hàng đã được thay đổi.", "success");
        },
        error: function () {
            swal.close();
            swal("Lỗi!", "Đã có lỗi xảy ra. Vui lòng thử lại sau.", "error");
        }
    });
}

$(window).on('hashchange', function () {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        } else {
            getData(page);
        }
    }
});
//
$(document).ready(function () {
    $(document).on('click', '.pagination a', function (event) {
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
    });
});


function movePrevious() {

    var currentPage = document.querySelector('.pagination .page-item.active');
    var prevpage = currentPage.previousElementSibling;
    if (!prevpage || prevpage.classList.contains('prev')) {
        return;
    }
    currentPage.classList.remove('active');
    prevpage.classList.add('active');
    var page = prevpage.querySelector('.page-link').innerText;
    getData(page);
};

function moveNext() {
    var currentPage = document.querySelector('.pagination .page-item.active');
    var nextPage = currentPage.nextElementSibling;
    if (!nextPage || nextPage.classList.contains('next')) {
        return;
    }
    currentPage.classList.remove('active');
    nextPage.classList.add('active');
    var page = nextPage.querySelector('.page-link').innerText;
    getData(page);
}

function getData(page) {
    $.ajax({
        url: '/admin/donhang?page=' + page,
        type: "get",
        datatype: "json",
        data:{
            ngay: ngaydef,
            trangthai: trangthaidef,
        }
    })
        .done(function (data) {
            $("#danhmuc-list").empty().html(data.data);
            $("#danhsachtrang").empty().html(data.paginate);

            location.hash = page;
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });
}

function search() {
    var search = document.querySelector('#tags-search').value;
    $.ajax({
        url: '/admin/sanpham?search=' + search,
        type: "get",
        datatype: "json",
    })
        .done(function (data) {

            $("#danhmuc-list").empty().html(data.data);
            $("#danhsachtrang").empty().html(data.paginate);

        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });

}

//Hàm lấy số trang hiện tại
function laysotrang() {
    var currentPage = document.querySelector('.pagination .page-item.active');
    if (!currentPage) {
        return null;
    }
    var link = currentPage.querySelector('.page-link');
    if (!link) {
        return null;
    }
    var pageNumber = link.innerText;
    return parseInt(pageNumber);
}

function locngay() {
    var ngay = document.querySelector('#loc-ngay').value;
    $.ajax({
        url: '/admin/donhang',
        type: "get",
        datatype: "json",
        data:{
            ngay:ngay,
            trangthai: trangthaidef,
        }
    })
        .done(function (data) {
            ngaydef = ngay;
            $("#danhmuc-list").empty().html(data.data);
            $("#danhsachtrang").empty().html(data.paginate);

        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });
}
function loctrangthai() {
    var trangthai = document.querySelector('#loc-trangthai').value;
    $.ajax({
        url: '/admin/donhang',
        type: "get",
        datatype: "json",
        data:{
            trangthai:trangthai,
            ngay:ngaydef,
        }
    })
        .done(function (data) {
            trangthaidef = trangthai;
            $("#danhmuc-list").empty().html(data.data);
            $("#danhsachtrang").empty().html(data.paginate);
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });
}

function handleKeyPress(event) {
    if (event.key === "Enter") {
        var madon = document.querySelector('#loc-madon').value;
        $.ajax({
            url: '/admin/donhang',
            type: "get",
            datatype: "json",
            data:{
                order_id:madon
            }
        })
            .done(function (data) {
                $("#danhmuc-list").empty().html(data.data);
                $("#danhsachtrang").empty().html(data.paginate);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
    }
}