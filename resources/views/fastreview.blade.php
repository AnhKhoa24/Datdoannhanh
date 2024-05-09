<div class="product-rating">
    @for ($i = 1; $i <= floor($sosao['sosao']); $i++)
        <i class="fa fa-star"></i>
    @endfor
    @for ($i = 1; $i <= 5 - floor($sosao['sosao']); $i++)
        <i class="fa fa-star-o"></i>
    @endfor
</div>
<a class="review-link" href="#">{{ $sosao['sodanhgia'] }} lượt đánh giá</a>