<thead>
    <tr>
        <th>Mã đơn</th>
        <th>Người đặt</th>
        <th>Người nhận</th>
        <th>Trạng thái</th>
        <th>Ngày đặt</th>
        <th>
            Thao tác
        </th>
    </tr>
</thead>

<tbody class="table-border-bottom-0" id="listdanhmuc">
    @foreach ($donhangs as $donhang)
        <tr>
            <td style="width: 10px;text-align: center; max-widtd:10px">{{ $donhang->order_id }}</td>
            <td style="width: 50px; white-space: normal;">
                {{ $donhang->name }}
                <br>
                {{ $donhang->email }}
            </td>
            <td>
                {{ $donhang->recipient_name }}
                <br>
                {{ $donhang->recipient_phone }}
                <br>
                <textarea name="" id="" cols="30" rows="1" placeholder="ĐC: {{ $donhang->recipient_address }}" readonly></textarea>
                
            </td>
            <td id="status_{{ $donhang->order_id }}">
                @if ($donhang->status == 1)
                    <button type="button" onclick="Duyet({{ $donhang->order_id }}, {{ $donhang->status }})"
                        class="btn btn-secondary">Xác nhận đơn hàng</button>
                @endif
                @if ($donhang->status == 2)
                    <button type="button" onclick="Duyet({{ $donhang->order_id }}, {{ $donhang->status }})"
                        class="btn btn-primary">Chuẩn bị hàng</button>
                @endif
                @if ($donhang->status == 3)
                    <button type="button" onclick="Duyet({{ $donhang->order_id }}, {{ $donhang->status }})"
                        class="btn btn-primary">Chuẩn bị xong</button>
                @endif
                @if ($donhang->status == 4)
                    <button type="button" onclick="Duyet({{ $donhang->order_id }}, {{ $donhang->status }})"
                        class="btn btn-primary">Giao hàng</button>
                @endif
                @if ($donhang->status == 5)
                    <button type="button" onclick="Duyet({{ $donhang->order_id }}, {{ $donhang->status }})"
                        class="btn btn-primary">Đã giao</button>
                @endif
                @if ($donhang->status == 6)
                    <span class="badge bg-success">Đơn hàng đã giao thành công!</span>
                @endif

            </td>
            <td>
                {{ date('d-m-Y', strtotime($donhang->created_at)) }}
            </td>
            <td><a href="/admin/donhang-xemthem/{{ $donhang->order_id }}">Xem thêm</a></td>
        </tr>
    @endforeach
</tbody>
