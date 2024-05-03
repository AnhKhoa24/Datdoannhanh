@extends('layouts.adminlayout')
@section('content')
    @if (session('success'))
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-primary bottom-0 end-0 show" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Thông báo</div>
                <small>Vừa xong</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    @endif


    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title">Danh sách sản phẩm</h5>
                <div class="d-flex">
                    <input name="search" id="tags-search" class="form-control me-2" type="search"
                        placeholder="Tìm kiếm ..." aria-label="Search">
                    <button class="btn btn-outline-success">Tìm</button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="danhmuc-list">
                    @include('admin.sanpham_data')
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-8">
                    <div class="demo-inline-spacing">
                        <nav aria-label="Page navigation" id="danhsachtrang">
                            @include('admin.sanpham_trang')
                        </nav>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
