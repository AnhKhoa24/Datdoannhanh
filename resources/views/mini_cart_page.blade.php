@php
$total = 0;
@endphp
@foreach (session('cart', []) as $item)
<tr>
    <td class="td-custom"> {{ $item['product_name'] }}</td>
    <td class="td-container">
        <div class="content">
            <img src="/uploads/{{ $item['photo_link'] }}">
        </div>
    </td>
    <td class="td-custom">
        <input id="quan_{{ $item['product_id'] }}"
            onkeydown="Loadgia(event, {{ $item['product_id'] }})" type="number"
            name="quantity" value="{{ $item['quantity'] }}" style="width: 50px;"
            min="1">
    </td>
    <td class="td-custom"> {{ number_format($item['price'], 0) }} đ
    </td>
    <td class="td-custom"> {{ number_format($item['quantity'] * $item['price'], 0) }} đ
    </td>

</tr>
@php
    $total += $item['quantity'] * $item['price'];
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