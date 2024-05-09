<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đặt đồ ăn nhanh</title>
    <link rel="icon" type="image/png" href="/assets2/img/2.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/assets2/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/assets2/css/slick.css" />
    <link type="text/css" rel="stylesheet" href="/assets2/css/slick-theme.css" />
    <link type="text/css" rel="stylesheet" href="/assets2/css/nouislider.min.css" />
    <link type="text/css" rel="stylesheet" href="/assets2/css/custom.css" />
    <link rel="stylesheet" href="/assets2/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/assets2/css/style.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="{{ asset('assets2/jquery.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets2/sweetalert.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    {{-- hỗ trợ chat box --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />

        <!--Start of Fchat.vn--><script type="text/javascript" src="https://cdn.fchat.vn/assets/embed/webchat.js?id=663ae355358e7b6c111f5fba" async="async"></script><!--End of Fchat.vn-->
</head>

<body>
    <header id="h-header">
        <div id="top-header">
            <div class="container">
                <ul class="header-links pull-left">
                    <li><a href="#"><i class="fa fa-phone"></i> +84 986404150</a></li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> anhkhoa.24052003@email.com</a></li>
                    <li><a href="#"><i class="fa fa-map-marker"></i>58/30 Trần Văn Dư</a></li>
                </ul>
                <ul class="header-links pull-right">
                    @if (Auth::user())
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-user-o"></i>{{ Auth::user()->name }}
                            </a>

                            <ul class="dropdown-menu">
                                <li><a href="/canhan" style="color: black;">Thông tin cá nhân</a></li>
                                <li><a href="#" id="submitLink" style="color: rgb(252, 0, 0);">Đăng xuất</a></li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}"><i class="fa fa-user-o"></i>Đăng nhập</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div id="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="/" class="logo">
                                <img src="/assets2/img/logo2.png" alt="" height="70px">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @yield('search_index')
                    </div>
                    <div class="col-md-3 clearfix">
                        <div class="header-ctn">

                            @if (Auth::check())
                                <div class="dropdown" id="minimes">
                                    @include('mini_mes')
                                </div>
                            @endif

                            @if (Auth::check())
                                <div class="dropdown" id="minicart">
                                    @include('minicart')
                                </div>
                            @endif
                            <div class="menu-toggle">
                                <a href="#">
                                    <i class="fa fa-bars"></i>
                                    <span>Menu</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div id="navigation">
        <div class="container">
            <div id="responsive-nav">
                <ul class="main-nav nav navbar-nav">
                    <li><a href="/">Sản phẩm</a></li>
                    <li><a href="/donhang">Đơn hàng</a></li>
                    <li><a href="/lichsudonhang">Lịch sử đơn hàng</a></li>
                    <li><a href="/dahuy">Đã hủy</a></li>
                </ul>
            </div>
        </div>
    </div>
    @yield('content')
    </head>
    <div id="notification" class="notification">
        <div class="notification-title">Bạn có một thông báo mới !</div>
        <div class="notification-content" id="notif-content">
        </div>
    </div>

    <footer id="footer">
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Về chúng tôi</h3>
                            <p>Mọi thắc, ý kiến, sự cố trong quá trình sử dụng, vui lòng liên hệ theo thông tin sau
                            </p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fa fa-map-marker"></i>58/30 Trần Văn Dư Q.TB</a>
                                </li>
                                <li><a href="#"><i class="fa fa-phone"></i>+84 986404150</a></li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i>anhkhoa.24052003@email.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Danh mục</h3>
                            <ul class="footer-links">
                                <li><a href="#">Hot deals</a></li>
                                <li><a href="#">Nước uống</a></li>
                                <li><a href="#">Đồ ăn nhanh</a></li>
                                <li><a href="#">Trà nóng</a></li>
                                <li><a href="#">Bánh ngọt</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix visible-xs"></div>
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Service</h3>
                            <ul class="footer-links">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">View Cart</a></li>
                                <li><a href="#">Wishlist</a></li>
                                <li><a href="#">Track My Order</a></li>
                                <li><a href="#">Help</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="bottom-footer" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="footer-payments">
                            <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
                        </ul>
                        <span class="copyright">
                            Khoadev &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> datdoannhanh.com
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @if (Auth::user())
        <form id="myForm" method="POST" action="{{ route('logout') }}">
            @csrf
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                var myForm = document.getElementById('myForm');
                var submitLink = document.getElementById('submitLink');

                submitLink.addEventListener('click', function(event) {

                    event.preventDefault();
                    myForm.submit();
                });
            });
        </script>
    @endif

    @if (Auth::check())
        <script>
            var user_id = "{{ Auth::user()->id }}";
        </script>
    @endif
    <script>var csrfToken = "{{ csrf_token() }}";</script>
    <script src="/assets2/js/bootstrap.min.js"></script>
    <script src="/assets2/js/slick.min.js"></script>
    <script src="/assets2/js/nouislider.min.js"></script>
    <script src="/assets2/js/jquery.zoom.min.js"></script>
    <script src="/assets2/js/main.js"></script>
    <script src="{{ asset('assets2/custom.js') }}"></script>
    <script src="{{ asset('assets2/realtime.js') }}"></script>
</body>

</html>
