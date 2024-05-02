
function themdanhmuc() {
    swal({
        text: "Nhập tên danh mục vào đây:",
        content: "input",
        buttons: {
            cancel: "Thoát",
            confirm: {
                text: "Thêm",
                value: true,
            },
        },
    })
        .then((value) => {
            if (value === "") {
                swal("Bạn không nhập gì cả!");
            } else if (value === null) {
                swal("Bạn đã thoát ra!");
            } else {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/admin/danhmuc",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        tendanhmuc: value
                    },
                    success: function (response) {
                        var trang = laysotrang();
                        getData(trang);
                        swal("Thành công!", "Bạn đã thêm mới một danh mục!", "success");
                    }
                })

            }
        });
}


function suaDanhMuc(ma_danhmuc, tendanhmuc) {

    document.getElementById(ma_danhmuc).innerHTML = `<td>${ma_danhmuc}</td>
    <td><input id="tendanhmuc_${ma_danhmuc}" type="text" name="tendanhmuc" value="${tendanhmuc}" size="40" /></td>
    <td>
    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
    <button type="button" class="btn btn-success" onclick="luuDanhMuc(${ma_danhmuc})">Lưu lại</button>
    <button type="button" class="btn btn-warning" onclick="thoatDanhmuc(${ma_danhmuc},'${tendanhmuc}')">Thoát</button>
  </div>
    </td>
    `;
}

function luuDanhMuc(ma_danhmuc) {
    var id = "tendanhmuc_" + ma_danhmuc;
    var tendanhmuc = document.getElementById(id).value;

    if (tendanhmuc != "") {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/editdanhmuc",
            type: 'POST',
            dataType: "json",
            data: {
                ma_danhmuc: ma_danhmuc,
                tendanhmuc: tendanhmuc,
            },
            success: function (response) {
                if (response == 1) {
                    document.getElementById(ma_danhmuc).innerHTML = `
                    <td>${ma_danhmuc}</td>
                    <td>${tendanhmuc}</td>
                    <td>
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#" onclick="suaDanhMuc(${ma_danhmuc},'${tendanhmuc}')"
                        ><i class="bx bx-edit-alt me-1"></i> Sửa</a
                      >
                      <a class="dropdown-item" href="#" onclick="xoaDanhMuc(${ma_danhmuc})"
                        ><i class="bx bx-trash me-1"></i>Xóa</a
                      >
                    </div>
                  </div>
                    </td>
                    `;
                    swal("Cập nhật thành công!", "Bạn vừa cập nhật tên danh mục thành công!", "success");
                }
            }
        })
    }
    else {
        swal("Tên danh mục trống!", "...bạn không được bỏ trống!");
    }

}
function thoatDanhmuc(ma_danhmuc, tendanhmuc) {
    document.getElementById(ma_danhmuc).innerHTML = `
    <td>${ma_danhmuc}</td>
    <td>${tendanhmuc}</td>
    <td>
        <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#" onclick="suaDanhMuc(${ma_danhmuc},'${tendanhmuc}')"
                ><i class="bx bx-edit-alt me-1"></i> Sửa</a
              >
              <a class="dropdown-item" href="#" onclick="xoaDanhMuc(${ma_danhmuc})"
                ><i class="bx bx-trash me-1"></i>Xóa</a
              >
            </div>
          </div>
    </td>
    `;
}

function xoaDanhMuc(ma_danhmuc) {
    swal({
        title: "Bạn muốn xóa?",
        text: "Bạn có chắc muốn xóa đi danh mục này không!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/admin/xoadanhmuc",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        ma_danhmuc: ma_danhmuc
                    },
                    success: function (response) {

                        if (response == 1) {
                            document.getElementById(ma_danhmuc).remove();
                            const trCount = document.getElementById('listdanhmuc').getElementsByTagName('tr').length;
                            var sotrang = laysotrang();
                            trCount < 1 ? sotrang = sotrang - 1 : sotrang;
                            if (trCount < 8) {
                                getData(sotrang);
                            }
                            swal("Keeee! Bạn đã xóa thành công!", {
                                icon: "success",
                            });
                        }
                        else {
                            swal("Oops! Xóa thất bại, do sản phẩm còn tồn tại trong danh mục", {
                                icon: "warning",
                            });
                        }

                    }
                })

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
        url: '/admin/danhmuc?page=' + page,
        type: "get",
        datatype: "json",
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

$(function livesearch() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/danhmuc/getname",
        type: 'POST',
        dataType: "json",
        success: function (data) {
            $("#tags-search").autocomplete({
                source: data
            });
        }
    });

});

function search()
{
    var search = document.querySelector('#tags-search').value;
    $.ajax({
        url: '/admin/danhmuc?search=' + search,
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