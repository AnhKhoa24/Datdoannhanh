<span class="store-qty">Coding by AnhKhoa</span>
<ul class="store-pagination" id="pagination">
    @for ($i = 1; $i <= $sotrang; $i++)
        @if ($i == $trang)
            <li class="active"><a href="/?page={{ $i }}">{{ $i }}</a></li>
        @else
            <li><a href="/?page={{ $i }}">{{ $i }}</a></li>
        @endif
    @endfor
    <li class="next"><a href="/?page=next"><i class="fa fa-angle-right"></i></a></li>

</ul>

