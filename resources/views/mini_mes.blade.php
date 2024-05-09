    <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-solid fa-bell"></i>
        <span>Thông báo</span>
        <div class="qty">{{ $sl }}</div>
    </a>
    <div class="cart-dropdown">
        <div class="cart-list" id="mess-show">
            @if ($sl < 1)
                Không có tin nhắn
            @else
                @foreach ($tinnhans as $tinnhan)
                    <!-- Thông báo -->
                    <div class="message" id="mes-{{ $tinnhan->id }}">
                        <div class="content-m">
                            <div class="author">{{ $tinnhan->sender }}</div>
                            <div class="text">{{ $tinnhan->content }}</div>
                            <div class="time"> {{ date('h:i A', strtotime($tinnhan->created_at)) }}</div>
                        </div>
                        <button class="xoatn" onclick="xoaMes({{ $tinnhan->id }})"><i
                                class="fa fa-solid fa-trash"></i></button>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="cart-btns">
            <a style="width: 100%;" onclick="xoaAllMes({{ Auth::user()->id }})" href="#">Xóa tất cả <i
                    class="fa fa-solid fa-trash"></i></a>
        </div>
    </div>
