@extends('layouts.adminlayout')
@section('content')
    @if (session('success'))
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-primary bottom-0 end-0 show" role="alert"
            aria-live="assertive" aria-atomic="true" data-delay="2000">
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
                <h5 class="card-title">Danh sách đơn hàng</h5>
                <div class="d-flex">
                    <input id="loc-ngay" class="form-control me-2" type="date" onchange="locngay()">
                    <select id="loc-trangthai" class="form-control me-2" onchange="loctrangthai()">
                        <option value="-1" selected hidden>Trạng thái</option>
                        <option value="1">Xác nhận đơn hàng</option>
                        <option value="2">Chuẩn bị hàng</option>
                        <option value="3">Chuẩn bị xong</option>
                        <option value="4">Giao hàng</option>
                        <option value="5">Xác nhận đã giao</option>
                        <option value="6">Đã giao thành công</option>
                    </select>
                    <input id="loc-madon" class="form-control me-2" type="number" placeholder="Mã đơn ..."
                        aria-label="Search" onkeydown="handleKeyPress(event)">

                </div>
                <a href="/admin/donhang"> <button class="btn btn-outline-success">Refresh</button></a>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="danhmuc-list">
                    @include('admin.donhang_data')
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-8">
                    <div class="demo-inline-spacing">
                        <nav aria-label="Page navigation" id="danhsachtrang">
                            @include('admin.donhang_trang')
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var csrf = "{{ csrf_token() }}"
    </script>
    <script src="{{ asset('assets/donhang.js') }}"></script>
@endsection
