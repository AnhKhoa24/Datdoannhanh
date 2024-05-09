<thead>
    <tr>
        <th>Xem</th>
        <th>Nội dung</th>
        <th>Thao tác</th>
        <th>
        </th>
    </tr>
</thead>
<tbody class="table-border-bottom-0" id="listdanhmuc">
    @foreach ($yeucaus as $yeucau)
        <tr id="xoayeucau_{{ $yeucau->more }}">
            <td>
                <a href="">Đơn hàng {{ $yeucau->more }}</a>
            </td>
            <td>{{ $yeucau->content }}</td>

            <td>
                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    <input onclick="duyetyeucau({{ $yeucau->more }})" type="checkbox" class="btn-check"
                        id="btncheck1" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btncheck1">Duyệt</label>

                    <input type="checkbox" class="btn-check" id="btncheck2" autocomplete="off">
                    <label class="btn btn-outline-danger" for="btncheck2">Từ chối</label>

                </div>
            </td>
        </tr>
    @endforeach
</tbody>