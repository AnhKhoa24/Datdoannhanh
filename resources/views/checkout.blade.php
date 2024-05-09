@extends('layouts.clientlayout')
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">Đặt hàng</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="/">Home</a></li>
                        <li class="active">Đặt hàng</li>
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

                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">Thông tin người nhận</h3>
                        </div>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Tên người nhận</label>
                                <input type="text" class="form-control" id="name" value="{{ $name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone">
                                <div id="emailHelp" class="form-text">Đây là số điện thoại để shipper liên hệ với bạn</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tỉnh</label>
                                <select onchange="chonTinh()" class="form-control" name="" id="select-tinh">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quận/Huyện</label>
                                <select onchange="chonQH()" class="form-control" name="" id="select-qh">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phường/Xã</label>
                                <select onchange="chonPX()" class="form-control" name="" id="select-px">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chi tiết đường, số nhà</label>
                                <input type="text" class="form-control" id="address">
                            </div>
                        </form>
                    </div>
                    <!-- /Billing Details -->
                    <!-- Order notes -->
                    <div class="order-notes">
                        <textarea class="input" id="note" placeholder="Ghi chú"></textarea>
                    </div>
                    <!-- /Order notes -->
                </div>

                <!-- Order Details -->
                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Đơn hàng</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>Sản phẩm</strong></div>
                            <div><strong>Tổng</strong></div>
                        </div>
                        <div class="order-products">
                            @php
                                $total = 0;
                            @endphp
                            @foreach (session('cart', []) as $item)
                                <div class="order-col">
                                    <div>x{{ $item['quantity'] }} {{ $item['product_name'] }}</div>
                                    <div>{{ number_format($item['price'] * $item['quantity'],0) }} đ</div>
                                </div>
                                @php
                                    $total += $item['price'] * $item['quantity'];
                                @endphp
                            @endforeach
                        </div>
                        <div class="order-col">
                            <div>Shiping</div>
                            <div><strong>FREE</strong></div>
                        </div>
                        <div class="order-col">
                            <div><strong>TOTAL</strong></div>
                            <div><strong class="order-total">{{ number_format($total,0) }} đ</strong></div>
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-1">
                            <label for="payment-1">
                                <span></span>
                                Thanh toán khi nhận hàng
                            </label>
                            <div class="caption">
                                <p>Bạn sẽ trả tiền trực tiếp cho shipper khi nhận hàng.</p>
                            </div>
                        </div>
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-2">
                            <label for="payment-2">
                                <span></span>
                                Chuyển khoản
                            </label>
                            <div class="caption">
                                <p>Tính năng đang được phát triển.</p>
                            </div>
                        </div>
                    </div>

                    <a onclick="dathang(event)" href="#" class="primary-btn order-submit">Đặt hàng</a>
                </div>
                <!-- /Order Details -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->


    <script>
        var csrfToken = "{{ csrf_token() }}"
    </script>
    <script src="{{ asset('assets2/address.js') }}"></script>
@endsection
