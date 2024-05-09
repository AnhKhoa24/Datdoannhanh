
    <div id="reviews">
        <ul class="reviews">
            @foreach ($danhgias as $danhgia)
                <li>
                    <div class="review-heading">
                        <h5 class="name">{{ $danhgia->rater }}</h5>
                        <p class="date">{{ date('d-m-Y H:i', strtotime($danhgia->created_at)) }}</p>
                        <div class="review-rating">
                            @for ($i = 1; $i <= $danhgia->sosao; $i++)
                            <i class="fa fa-star"></i>
                            @endfor
                            @for ($i = 1; $i <= 5-$danhgia->sosao; $i++)
                            <i class="fa fa-star-o empty"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="review-body">
                        <p> {{ $danhgia->content }}
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
