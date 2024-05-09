@extends('layouts.adminlayout')
@section('content')
    <style>
        .image-container {
            width: 65px;
            height: 65px;
            overflow: hidden;
            border: 2px solid #c9c8c8;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
        }

        .image-container img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
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
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><a href="/admin/donhang" class="text-muted fw-light">Đơn hàng </a>/
            {{ $title }}
        </h4>
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0"></h5>
                        {{-- <small class="text-muted float-end">Default label</small> --}}
                    </div>
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                            <div class="row">
                                <input type="hidden" id="inp-order_id" value="{{ $order->order_id }}">
                                <div class="mb-3 col-md-4">
                                    <label for="firstName" class="form-label"><strong>Người đặt:</strong></label>
                                    <span class="form-control"
                                        style="background-color: rgb(247, 245, 245);border: none">{{ $order->name }}</span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="firstName" class="form-label"><strong>Email:</strong> </label>
                                    <span class="form-control"
                                        style="background-color: rgb(247, 245, 245);border: none">{{ $order->email }}</span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="currency" class="form-label"><strong>Trạng thái</strong></label>
                                    <select id="inp-status" name="status" class="select2 form-select">
                                        <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đang xác nhận đơn hàng
                                        </option>
                                        <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Đã xác nhận đơn hàng
                                        </option>
                                        <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Đang chuẩn bị hàng</option>
                                        <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Đã chuẩn bị đơn hàng</option>
                                        <option value="5" {{ $order->status == 5 ? 'selected' : '' }}>Đang giao </option>
                                        <option value="6" {{ $order->status == 6 ? 'selected' : '' }}>Giao thành công</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="firstName" class="form-label"><strong>Người nhận</strong></label>
                                    <input id="inp-recipient_name" type="text" name="recipient_name" class="form-control"
                                        value="{{ $order->recipient_name }}" />
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="firstName" class="form-label"><strong>Số điện thoại</strong></label>
                                    <input id="inp-recipient_phone" type="text" name="recipient_phone"
                                        class="form-control" value="{{ $order->recipient_phone }}" />
                                </div>
                                <div class="mb-3 col-md-8">
                                    <label for="firstName" class="form-label"><strong>Địa chỉ</strong></label>
                                    <input id="inp-recipient_address" type="text" name="recipient_address"
                                        class="form-control" value="{{ $order->recipient_address }}" />
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="firstName" class="form-label"><strong>Phương thức thanh
                                            toán</strong></label>
                                    <input id="inp-payment" type="text" name="payment" class="form-control"
                                        value="{{ $order->payment }}" />
                                </div>
                                <div class="mb-3 col-md-8">
                                    <label for="firstName" class="form-label"><strong>Nội dung đơn hàng</strong></label>
                                    <span class="form-control" style="background-color: rgb(247, 245, 245);border: none">
                                        @if ($order->note == '')
                                            Không có
                                        @else
                                            {{ $order->note }}
                                        @endif
                                    </span>
                                </div>
                                <hr>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên sản phẩm</th>
                                                <th>Hình</th>
                                                <th>Số lượng</th>
                                                <th>Giá bán</th>
                                                <th>Giá gốc</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($sanphams as $sanpham)
                                                <tr>
                                                    <td>{{ $sanpham['product_name'] }}</td>
                                                    <td>
                                                        <div class="image-container"><img
                                                                src="/uploads/{{ $sanpham['photo_link'] }}"></div>

                                                    </td>
                                                    <td>
                                                        <input id="doi-soluong_{{ $sanpham['product_id'] }}"
                                                            onkeydown="Loadgia(event,{{ $order->order_id }},{{ $sanpham['product_id'] }})"
                                                            type="number" name="quantity"
                                                            value="{{ $sanpham['quantity'] }}" style="width: 50px;"
                                                            min="1">
                                                    </td>
                                                    <td>{{ number_format($sanpham['buy_price'], 0) }} đ</td>
                                                    <td>{{ number_format($sanpham['default_price'], 0) }} đ</td>
                                                    <td id="total-doi_{{ $sanpham['product_id'] }}">
                                                        {{ number_format($sanpham['total'], 0) }} đ</td>
                                                    <input type="hidden" id="gia-goc_{{ $sanpham['product_id'] }}"
                                                        value="{{ $sanpham['buy_price'] }}">
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="mt-2">
                                    <button onclick="SaveI4()" type="button" class="btn btn-primary me-2">Lưu thông
                                        tin</button>
                                    <button type="button" class="btn btn-outline-danger">Hủy đơn</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var csrfToken = "{{ csrf_token() }}"
    </script>
    <script>
        function Loadgia(event, order_id, product_id) {
            if (event.key === "Enter") {
                var soluong = document.getElementById('doi-soluong_' + product_id).value;
                var by_price = document.getElementById('gia-goc_' + product_id).value;
                var total = parseInt(soluong) * parseInt(by_price);
                $.ajax({
                    url: "/doisoluong",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        product_id: product_id,
                        order_id: order_id,
                        quantity: soluong,
                        total: total,
                        "_token": csrfToken,
                    },
                    success: function(data) {
                        var totaltext = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        document.getElementById('total-doi_' + product_id).innerHTML = totaltext + "đ";
                    },
                    error: function() {

                    }
                });
            }
        }

        function SaveI4() {
            var status = document.getElementById('inp-status').value;
            var recipient_name = document.getElementById('inp-recipient_name').value;
            var recipient_phone = document.getElementById('inp-recipient_phone').value;
            var recipient_address = document.getElementById('inp-recipient_address').value;
            var payment = document.getElementById('inp-payment').value;
            var order_id = document.getElementById('inp-order_id').value;
            swal({
                title: "Đang xử lý...",
                text: "Vui lòng đợi trong giây lát",
                icon: "info",
                buttons: false,
                closeOnClickOutside: false,
            });
            $.ajax({
                url: "/admin/donhang-savechages",
                type: "POST",
                delay: 250,
                data: {
                    "_token": csrfToken,
                    status: status,
                    recipient_name: recipient_name,
                    recipient_phone: recipient_phone,
                    recipient_address: recipient_address,
                    payment: payment,
                    order_id: order_id,
                },
                success: function(response) {

                    swal.close();
                    swal({
                        title: 'Thành công!',
                        text: 'Cập nhật thành công thông tin đơn hàng!',
                        icon: 'success',
                    })
                },
                error: function() {
                    swal.close();
                    swal("Lỗi!", "Đã có lỗi xảy ra. Vui lòng thử lại sau.", "error");
                }
            });
        }
    </script>
@endsection
