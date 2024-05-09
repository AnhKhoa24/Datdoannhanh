<ul class="pagination justify-content-center">
    <li class="page-item prev">
        <button onclick="movePrevious()" class="page-link"><i
                class="tf-icon bx bx-chevrons-left"></i></button>
    </li>
    @for ($i = 1; $i <= $sotrang; $i++)
        @if ($i == $trang)
            <li class="page-item active">
                <a class="page-link"
                    href="/admin/sanpham?page={{ $i }}">{{ $i }}</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link"
                    href="/admin/sanpham?page={{ $i }}">{{ $i }}</a>
            </li>
        @endif
    @endfor

    <li class="page-item next">
        <button class="page-link" onclick="moveNext()"><i
                class="tf-icon bx bx-chevrons-right"></i></button>
    </li>
</ul>