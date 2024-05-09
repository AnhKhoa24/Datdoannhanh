<div id="review-form">
    <form class="review-form">
        <input id="dg-name" class="input" type="text" placeholder="Your Name"
            value="{{ Auth::check() ? Auth::user()->name : '' }}">
        <input id="dg-email" class="input" type="email" placeholder="Your Email"
            value="{{ Auth::check() ? Auth::user()->email : '' }}">
        <textarea id="dg-content" class="input" placeholder="Your Review"></textarea>
        <div class="input-rating">
            <span>Your Rating: </span>
            <div class="stars">
                <input id="star5" name="rating" value="5"
                    type="radio"><label for="star5"></label>
                <input id="star4" name="rating" value="4"
                    type="radio"><label for="star4"></label>
                <input id="star3" name="rating" value="3"
                    type="radio"><label for="star3"></label>
                <input id="star2" name="rating" value="2"
                    type="radio"><label for="star2"></label>
                <input id="star1" name="rating" value="1"
                    type="radio"><label for="star1"></label>
            </div>
        </div>
        <button type="button" onclick="danhgia({{ $sanpham->product_id }})"
            class="primary-btn">Đánh giá</button>
    </form>
</div>