@extends('layouts.adminlayout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title">Danh sách công việc</h5>
                <form class="d-flex" method="GET" action="/congviec">
                    <input name="search" value="{{ $search }}" class="form-control me-2" type="search"
                        placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Tìm</button>
                </form>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã danh mục</th>
                            <th>Tên danh mục</th>

                            <th> <button class="btn rounded-pill btn-outline-dark" onclick="themdanhmuc()">Thêm</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="listdanhmuc">
                        @foreach ($danhmucs as $danhmuc)
                            <tr>
                                <td>{{ $danhmuc->ma_danhmuc }}</td>
                                <td>{{ $danhmuc->tendanhmuc }}</td>

                                <td>
                                    Sửa
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-centerx">

            </div>

            <nav aria-label="Page navigation">
                <ul class="pagination justify-content">
                    {{ $danhmucs->links('pagination::bootstrap-4') }}
                </ul>
            </nav>

        </div>

    </div>

    <script>
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
                            success: function(response) {


                                var newhtml = `
                                   <tr>
                                <td>${response.ma_danhmuc}</td>
                                <td>${response.tendanhmuc}</td>
                                <td>
                                    Sửa
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
    </script>
@endsection
