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

            @foreach ($donhangs as $item)
                <!-- row -->
                <div class="row" id="item-order_{{ $item->order_id }}">
                    <div class="col-md-7">
                        <!-- Billing Details -->
                        <div class="billing-details">
                            <div class="section-title">
                                <h5 id="doitrangthai-header" style="color: rgb(6, 156, 6)">Mã đơn: {{ $item->order_id }} ||
                                    Trạng thái: Đã giao thành công</h5>
                                <span>-Ngày đặt: {{ date('d-m-Y', strtotime($item->created_at)) }}| Lúc:
                                    {{ date('H:i', strtotime($item->created_at)) }}
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
                                    @if ($sanpham['order_id'] === $item->order_id)
                                        <tr>
                                            <td class="td-custom"> {{ $sanpham['products']['product_name'] }}</td>
                                            <td class="td-container">
                                                <div class="content">
                                                    <img src="/uploads/{{ $sanpham['products']['photo_link'] }}">
                                                </div>
                                            </td>
                                            <td class="td-custom"> {{ $sanpham['products']['quantity'] }}</td>
                                            <td class="td-custom"> {{ number_format($sanpham['products']['price'], 0) }} đ
                                            </td>
                                            <td class="td-custom"> {{ number_format($sanpham['products']['total'], 0) }} đ
                                            </td>

                                        </tr>
                                        @php
                                            $total += $sanpham['products']['total'];
                                        @endphp
                                    @endif
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
                <br id="br_{{ $item->order_id }}">
                <button id="but_{{ $item->order_id }}" type="submit" onclick="xoadon({{ $item->order_id }})" class="btn btn-primary">Xóa</button>
                <hr style="border: 1.5px solid #f50202;" id="hr_{{ $item->order_id }}">
                <!-- /row -->
            @endforeach

        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
<script>
    var token = "{{ csrf_token() }}";
</script>
    <script>
        function xoadon(order_id) {
            swal({
                    title: "Bạn muốn xóa?",
                    text: "Bạn có chắc muốn xóa đi đơn hàng này không!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "/xoadonhang",
                            type: 'POST',
                            dataType: "json",
                            data: {
                                order_id: order_id,
                                "_token": token,
                            },
                            success: function(response) {
                                document.getElementById('item-order_'+order_id).remove();
                                document.getElementById('hr_'+order_id).remove();
                                document.getElementById('br_'+order_id).remove();
                                document.getElementById('but_'+order_id).remove();
                                swal("Thành công", "Bạn đã xóa đơn hàng!", "success");
                            },
                            error: function()
                            {
                                alert("Lỗi server, vui lòng thử lại sau!");
                            }
                        })

                    }
                });
        }
    </script>
@endsection
