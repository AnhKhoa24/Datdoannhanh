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


                        var newhtml = `<tr id="${response.ma_danhmuc}">
                        <td>${response.ma_danhmuc}</td>
                        <td>${response.tendanhmuc}</td>
                        <td>
                        <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#" onclick="suaDanhMuc(${response.ma_danhmuc},'${response.tendanhmuc}')"
                            ><i class="bx bx-edit-alt me-1"></i> Sửa</a
                          >
                          <a class="dropdown-item" href="#" onclick="xoaDanhMuc(${response.ma_danhmuc})"
                            ><i class="bx bx-trash me-1"></i> Xóa</a
                          >
                        </div>
                      </div>
                        </td>
                             </tr>
                           `;
                        document.getElementById('listdanhmuc').insertAdjacentHTML('beforeend',
                            newhtml);
                        swal("Thành công!", "Bạn đã thêm mới một danh mục!", "success");
                    }
                })

            }
        });
}


function suaDanhMuc(ma_danhmuc, tendanhmuc) {

    document.getElementById(ma_danhmuc).innerHTML =`<td>${ma_danhmuc}</td>
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
                        ><i class="bx bx-trash me-1"></i> Delete</a
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
              <a class="dropdown-item" href="#"
                ><i class="bx bx-trash me-1"></i> Delete</a
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

                        if(response == 1)
                        {
                            document.getElementById(ma_danhmuc).remove();
                            swal("Keeee! Bạn đã xóa thành công!", {
                                icon: "success",
                            });
                        }
                        else
                        {
                            swal("Oops! Xóa thất bại, do sản phẩm còn tồn tại trong danh mục", {
                                icon: "warning",
                            });
                        }
                       
                    }
                })



            }
        });
}