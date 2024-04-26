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
                            <tr id="{{ $danhmuc->ma_danhmuc }}">
                                <td>{{ $danhmuc->ma_danhmuc }}</td>
                                <td>{{ $danhmuc->tendanhmuc }}</td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                          <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                          <a class="dropdown-item" href="#" onclick="suaDanhMuc({{ $danhmuc->ma_danhmuc }},'{{ $danhmuc->tendanhmuc }}')"
                                            ><i class="bx bx-edit-alt me-1"></i> Sửa</a
                                          >
                                          <a class="dropdown-item" href="#" onclick="xoaDanhMuc({{ $danhmuc->ma_danhmuc }})"
                                            ><i class="bx bx-trash me-1"></i> Xóa</a
                                          >
                                        </div>
                                      </div>
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

    <script src="{{ asset('assets/danhmuc.js') }}"></script>
@endsection
