@extends('layouts.clientlayout')
@section('content')
    <style>
        .td-custom {
            width: 200px;
            max-width: 200px;
            white-space: normal;
            text-align: center;
        }

        .content {
            width: 65px;
            height: 65px;
            overflow: hidden;
            border: 2px solid #c9c8c8;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
        }

        .content img {
            width: 100%;
            height: auto;
            display: block;
        }

        .td-container {
            height: 65px;
            text-align: center;
            vertical-align: middle;
        }

        .content {
            display: inline-block;
        }
    </style>

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
                            <h5>Mã đơn: {{ $donhang->order_id }} || Trạng thái:
                                @if ($donhang->status == 1)
                                    Đang xác nhận đơn hàng
                                @endif
                                @if ($donhang->status == 2)
                                    Đã xác nhận đơn hàng
                                @endif
                                @if ($donhang->status == 3)
                                    Đang chuẩn bị hàng
                                @endif
                                @if ($donhang->status == 4)
                                    Đã chuẩn bị đơn hàng
                                @endif
                                @if ($donhang->status == 5)
                                    Đang giao
                                @endif

                            </h5>
                            <span>-Ngày đặt: {{ date('d-m-Y', strtotime($donhang->created_at)) }}| Lúc:
                                {{ date('H:i', strtotime($donhang->created_at)) }}
                            </span>
                            <br>
                            <span>
                                -Người nhận: {{ $donhang->recipient_name }} |SĐT: {{ $donhang->recipient_phone }}
                                <br>
                                -Địa chỉ: {{ $donhang->recipient_address }}
                            </span>

                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="col-md-12 order-details">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="td-custom" scope="col">Tên</th>
                                <th class="td-custom" scope="col">Hình</th>
                                <th class="td-custom" scope="col">Số lượng</th>
                                <th class="td-custom" scope="col">Giá</th>
                                <th class="td-custom" scope="col">Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($sanphams as $sanpham)
                                <tr>
                                    <td class="td-custom"> {{ $sanpham['product_name'] }}</td>
                                    <td class="td-container">
                                        <div class="content">
                                            <img src="/uploads/{{ $sanpham['photo_link'] }}">
                                        </div>
                                    </td>
                                    <td class="td-custom"> {{ $sanpham['quantity'] }}</td>
                                    <td class="td-custom"> {{ number_format($sanpham['price'], 0) }} đ
                                    </td>
                                    <td class="td-custom"> {{ number_format($sanpham['total'], 0) }} đ
                                    </td>

                                </tr>
                                @php
                                    $total += $sanpham['total'];
                                @endphp
                            @endforeach
                            <tr>
                                <td class="td-custom"></td>
                                <td class="td-custom"></td>
                                <td class="td-custom"></td>
                                <td class="td-custom"><strong>Tổng tiền: </strong></td>
                                <td class="td-custom"><strong> {{ number_format($total, 0) }} đ</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /Order Details -->
            </div>
            <hr style="border: 1.5px solid #f50202;">
            <!-- /row -->
            <a onclick="huydonhang({{ $donhang->order_id }})" href="#" class="primary-btn order-submit">Yêu cầu hủy
                đơn</a>

        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <script>
        function huydonhang(order_id) {
            swal({
                title: "Đang xử lý...",
                text: "Vui lòng đợi trong giây lát",
                icon: "info",
                buttons: false,
                closeOnClickOutside: false,
            });
            $.ajax({
                url: "/yeucauhuydon",
                type: "POST",
                delay: 250,
                data: {
                    "_token": csrfToken,
                    order_id: order_id,
                },
                success: function(response) {
                    if (response == 1) {
                        swal.close();
                        swal("Đã hủy", "Đơn hàng của bạn đã được hủy.", "success").then((value) => {
                            if (value) {
                                window.location.href = "/donhang";
                            }
                        });
                    } else if (response == 0) {
                        swal.close();
                        swal("Đã gửi yêu cầu", "Yêu cầu hủy đơn hàng của bạn đã được xác nhận.", "success")
                            .then((value) => {
                                if (value) {
                                    window.location.href = "/donhang";
                                }
                            });
                    }

                },
                error: function() {
                    swal.close();
                    swal("Lỗi!", "Đã có lỗi xảy ra. Vui lòng thử lại sau.", "error");
                }
            });
        }
    </script>
@endsection
