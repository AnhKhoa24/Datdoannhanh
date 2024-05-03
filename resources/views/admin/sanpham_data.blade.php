<thead>
    <tr>
        <th>Mã sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Giá bán</th>
        <th>Danh mục</th>
        <th>
            <a href="/admin/sanpham-them"><button class="btn rounded-pill btn-outline-dark">Thêm</button></a>
        </th>
    </tr>
</thead>
<tbody class="table-border-bottom-0" id="listdanhmuc">
   @foreach ($sanphams as $sanpham)
       <tr>
        <td>{{ $sanpham->product_id }}</td>
        <td>{{ $sanpham->product_name }}</td>
        <td>{{ number_format($sanpham->price, 0) }} vnđ</td>
        <td>{{ $sanpham->tendanhmuc }}</td>
        <td>Xem thêm</td>
       </tr>
   @endforeach
</tbody>
