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
                            <h5>Giỏ hàng:
                            </h5>
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
                        <tbody id="cart_list_cay">
                          @include('mini_cart_page')
                        </tbody>
                    </table>
                </div>
                <!-- /Order Details -->
            </div>
            <hr style="border: 1.5px solid #f50202;">
            <!-- /row -->
            <a href="/checkout" class="primary-btn order-submit">Thanh toán</a>

        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <script>
        var csrfToken = "{{ csrf_token() }}"
    </script>
    <script>
        function Loadgia(event, product_id) {
            if (event.key === "Enter") {
                var soluong = document.getElementById('quan_' + product_id).value;
                $.ajax({
                    url: "/add-to-cart",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        product_id: product_id,
                        quantity: soluong,
                        stt: 1,
                        "_token": csrfToken,
                    },
                    success: function(response) {
                        $("#minicart").empty().html(response.giohang);
                        $("#cart_list_cay").empty().html(response.cart_list);
                        console.log(data.giohang);
                    },
                    error: function() {

                    }
                });
            }
        }
    </script>
@endsection
