@extends('layouts.clientlayout')

@section('search_index')
    <div class="header-search">
        <form action="">
            <input id="tags" type="search" class="input input-select" placeholder="Tìm kiếm sản phẩm...">
            <button type="button" onclick="Search()" class="search-btn">Tìm kiếm</button>
        </form>
    </div>
@endsection

@section('content')
    <style>
        .scrolling-text {
            overflow: hidden;
            white-space: nowrap;
            width: 100%;
        }

        .scrolling-text span {
            display: inline-block;
            font-size: 1.2em;
            font-weight: bold;
            color: #D10024;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>
    <div class="section">
        <div class="container">
            <div id="store" class="col-md-12">
                
                <div class="row" id="sanpham-list">

                    @include('data')

                </div>
                <div class="store-filter clearfix" id="trang-list">
                    @include('linkpages')
                </div>
            </div>
        </div>
    </div>
    <script>
        var csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('assets2/index.js') }}"></script>
@endsection
