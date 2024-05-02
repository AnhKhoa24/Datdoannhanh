@extends('layouts.adminlayout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title">Danh sách danh mục</h5>
                <div class="d-flex">
                    <input name="search" id="tags-search" class="form-control me-2" type="search"
                        placeholder="Tìm kiếm ..." aria-label="Search">
                    <button class="btn btn-outline-success" onclick="search()">Tìm</button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="danhmuc-list">
                    @include('admin.danhmuc_data')
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-8">
                    <div class="demo-inline-spacing">
                        <nav aria-label="Page navigation" id="danhsachtrang">
                           @include('admin.danhmuc_trang')
                        </nav>

                    </div>
                </div>
            </div>
        </div>


    </div>


    <script src="{{ asset('assets/danhmuc.js') }}"></script>
@endsection
