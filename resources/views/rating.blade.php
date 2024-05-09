<div id="rating">
    <div class="rating-avg">
        <span>{{ $sosao['sosao'] }}</span>
        <div class="rating-stars">
            @for ($i = 1; $i <= floor($sosao['sosao']); $i++)
                <i class="fa fa-star"></i>
            @endfor
            @for ($i = 1; $i <= 5 - floor($sosao['sosao']); $i++)
                <i class="fa fa-star-o"></i>
            @endfor
        </div>
    </div>
    <ul class="rating">
        <li>
            <div class="rating-stars">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </div>
            <div class="rating-progress">
                <div style="width: 80%;"></div>
            </div>
            <span class="sum">{{ $sosao['sao_5'] }}</span>
        </li>
        <li>
            <div class="rating-stars">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <div class="rating-progress">
                <div style="width: 60%;"></div>
            </div>
            <span class="sum">{{ $sosao['sao_4'] }}</span>
        </li>
        <li>
            <div class="rating-stars">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <div class="rating-progress">
                <div></div>
            </div>
            <span class="sum">{{ $sosao['sao_3'] }}</span>
        </li>
        <li>
            <div class="rating-stars">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <div class="rating-progress">
                <div></div>
            </div>
            <span class="sum">{{ $sosao['sao_2'] }}</span>
        </li>
        <li>
            <div class="rating-stars">
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <div class="rating-progress">
                <div></div>
            </div>
            <span class="sum">{{ $sosao['sao_1'] }}</span>
        </li>
    </ul>
</div>
