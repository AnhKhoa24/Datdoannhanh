@extends('layouts.clientlayout')
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="/">Sản phẩm</a></li>
                        <li class="active">{{ $sanpham->product_name }}</li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- Product main img -->
                <div class="col-md-5 col-md-push-2">
                    <div id="product-main-img">
                        @foreach ($photos as $photo)
                            <div class="product-preview">
                                <img src="/uploads/{{ $photo->photo_link }}" alt="" height="300px">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /Product main img -->

                <!-- Product thumb imgs -->
                <div class="col-md-2  col-md-pull-5">
                    <div id="product-imgs">
                        @foreach ($photos as $photo)
                            <div class="product-preview">
                                <img src="/uploads/{{ $photo->photo_link }}" alt="" height="100px">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /Product thumb imgs -->

                <!-- Product details -->
                <div class="col-md-5">
                    <div class="product-details">
                        <h2 class="product-name">{{ $sanpham->product_name }}</h2>
                        <div id="area-freview">
                            @include('fastreview')
                        </div>
                        <div>
                            <h3 class="product-price">{{ number_format($sanpham->price) }} đ</h3>
                            <span class="product-available">Có sẵn</span>
                        </div>
                        <p>{{ $sanpham->description }}</p>

                        <div class="add-to-cart">
                            <div class="qty-label">
                                Qty
                                <div class="input-number">
                                    <input id="inp-quantity" type="number" value="1">
                                    <span class="qty-up">+</span>
                                    <span class="qty-down">-</span>
                                </div>
                            </div>
                            <button onclick="themgiohang({{ $sanpham->product_id }})" type="button"
                                class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                        </div>

                        <ul class="product-links">
                            <li>Danh mục:</li>
                            <li><a href="#">{{ $sanpham->tendanhmuc }}</a></li>
                        </ul>

                    </div>
                </div>
                <!-- /Product details -->

                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                        <!-- product tab nav -->
                        <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">Đánh giá (3)</a></li>
                        </ul>
                        <!-- /product tab nav -->

                        <!-- product tab content -->
                        <div class="tab-content">
                            <!-- tab3  -->
                            <div class="tab-pane show">
                                <div class="row">
                                    <div class="col-md-3" id="area-rating">
                                        @include('rating')
                                    </div>
                                    <div class="col-md-6" id="area-review">
                                        @include('reviews')
                                    </div>
                                    <!-- Review Form -->
                                    <div class="col-md-3" id="area-reform">
                                        @include('reviewform')
                                    </div>
                                    <!-- /Review Form -->
                                </div>
                            </div>
                            <!-- /tab3  -->
                        </div>
                        <!-- /product tab content  -->
                    </div>
                </div>
                <!-- /product tab -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
    @if (Auth::check())
        <script>
            var user_id = "{{ Auth::user()->id }}"
        </script>
    @endif
    <script src="{{ asset('assets2/chitiet_sanpham.js') }}"></script>
@endsection
