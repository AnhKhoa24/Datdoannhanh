  @foreach ($sanphams as $sanpham)
     
          <div class="col-md-3 col-xs-6">
              <div class="product">
                <a href="/chitiet/{{ $sanpham->product_id }}">
                  <div class="product-img">
                      <img src="/uploads/{{ $sanpham->photo_link }}" alt="" height="200px">
                      <div class="product-label">
                          <span class="sale">-30%</span>
                          <span class="new">NEW</span>
                      </div>
                  </div>
                  <div class="product-body">
                      <p class="product-category">{{ $sanpham->tendanhmuc }}</p>
                      <div class="scrolling-text">
                          <span>{{ $sanpham->product_name }}</span>
                      </div>

                      <h4 class="product-price"><u
                              style="font-size: smaller">đ</u>{{ number_format($sanpham->price, 0) }}
                      </h4>
                  </div>
                </a>

                  <div class="add-to-cart">
                      <button onclick="addToCart({{ $sanpham->product_id }})" class="add-to-cart-btn"><i
                              class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                  </div>
              </div>
          </div>
  @endforeach
