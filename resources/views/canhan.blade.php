@extends('layouts.clientlayout')
@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">Thông tin cá nhân</h3>
                        </div>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Tên người dùng</label>
                                <input placeholder="Tên người dùng" type="text" class="form-control" id="name"
                                    value="{{ Auth::user()->name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input placeholder="Email" type="text" class="form-control" id="email"
                                    value="{{ Auth::user()->email }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" placeholder="******">
                            </div>
                        </form>
                    </div>
                    <button type="button" onclick="saveinfor({{ Auth::user()->id }})" class="btn btn-primary">Lưu thông
                        tin</button>
                    <button type="button" onclick="huytaikhoan({{ Auth::user()->id }})" class="btn btn-danger">Hủy tài
                        khoản</button>

                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->


    <script>
        var csrfToken = "{{ csrf_token() }}"
    </script>
    <script>
        function huytaikhoan(user_id) {
            swal({
                text: "Nhập mật khẩu:",
                content: "input",
                buttons: {
                    cancel: "Thoát",
                    confirm: {
                        text: "Xác nhận",
                        value: true,
                    },
                },
            }).then((value) => {
                if (value === "") {
                    swal("Bạn không nhập gì cả!");
                } else if (value === null) {
                    return;
                } else {
                    xoa(user_id,value);
                }
            })
        }

        function saveinfor(user_id) {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            if (name === "" || email === "") {
                swal("Haizz!", "Bạn nhập thiếu thông tin hoặc chưa thay đổi!", "warning");
                return;
            }
            swal({
                text: "Nhập mật khẩu:",
                content: "input",
                buttons: {
                    cancel: "Thoát",
                    confirm: {
                        text: "Xác nhận",
                        value: true,
                    },
                },
            }).then((value) => {
                if (value === "") {
                    swal("Bạn không nhập gì cả!");
                } else if (value === null) {
                    return;
                } else {
                    check(user_id, value);
                }
            })

        }

        function check(user_id, password) {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var newpassword = document.getElementById("password").value;
            $.ajax({
                url: 'kiemtra-user',
                type: 'POST',
                data: {
                    password: password,
                    user_id: user_id,
                    name: name,
                    email: email,
                    newpassword: newpassword,
                    "_token": csrfToken
                },
                success: function(response) {
                    if (response) {
                        swal("Thành công!", "Bạn đã thay đổi thành công!", "success");
                    } else {
                        swal("Haiz!", "Sai mật khẩu!", "warning");
                    }
                },
                error: function() {
                    alert("Lỗi server, vui lòng thử lại sau")
                    return false;
                }
            })
        }

        function xoa(user_id, password) {
            $.ajax({
                url: '/huytaikhoan',
                type: 'POST',
                data: {
                    user_id: user_id,
                    password: password,
                    "_token": csrfToken
                },
                success: function(response) {
                    if (response) {
                        window.location.href="/";
                    } else {
                        swal("Haiz!", "Sai mật khẩu!", "warning");
                    }
                },
                error: function() {
                    alert("Lỗi server, vui lòng thử lại sau")
                    return false;
                }
            })
        }
    </script>
@endsection
