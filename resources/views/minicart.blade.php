<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
    <i class="fa fa-shopping-cart"></i>
    <span>Giỏ hàng</span>
    <div class="qty">{{ count(session('cart', [])) }}</div>
</a>
<div class="cart-dropdown">
    <div class="cart-list">
        @php
        $total = 0;
        @endphp
        @foreach (session('cart', []) as $item)
        <div class="product-widget">
            <div class="product-img">
                <img src="{{ asset('uploads/' . $item['photo_link']) }}"
                    alt="">
            </div>
            <div class="product-body">
                <h3 class="product-name"><a
                        href="#">{{ $item['product_name'] }}</a>
                </h3>
                <h4 class="product-price"><span
                        class="qty">{{ $item['quantity'] }}x
                    </span>{{ number_format($item['price'] * $item['quantity'], 0) }} đ
                </h4>
            </div>
            <button class="delete" onclick="removeProCart({{ $item['product_id'] }})"><i class="fa fa-close"></i></button>
        </div>
        @php
            $total += $item['price']*$item['quantity']
        @endphp
        @endforeach
    </div>
    <div class="cart-summary">
        <small>{{ count(session('cart', [])) }} sản phẩm được chọn</small>
        <h5>Tổng tiền: {{ number_format($total,0) }} đ</h5>
    </div>
    <div class="cart-btns">
        <a href="/giohang">Xem giỏ hàng</a>
        <a href="/checkout" id="checkout">Thanh toán <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>