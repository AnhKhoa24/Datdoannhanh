@extends('layouts.adminlayout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title">Danh sách danh mục</h5>
                <form class="d-flex" method="GET" action="/admin/danhmuc" onsubmit="return  ()">
                    <input name="search" value="{{ $search }}" class="form-control me-2" type="search"
                        placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Tìm</button>
                </form>
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
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item prev">
                                    <button onclick="movePrevious()" class="page-link"><i
                                            class="tf-icon bx bx-chevrons-left"></i></button>
                                </li>
                                @for ($i = 1; $i <= $sotrang; $i++)
                                    @if ($i == 1)
                                        <li class="page-item active">
                                            <a class="page-link" href="/admin/danhmuc?page=1">1</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="/admin/danhmuc?page={{ $i }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor

                                <li class="page-item next">
                                    <button class="page-link" onclick="moveNext()"><i
                                            class="tf-icon bx bx-chevrons-right"></i></button>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>


    </div>


    <script src="{{ asset('assets/danhmuc.js') }}"></script>
@endsection
