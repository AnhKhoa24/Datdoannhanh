@extends('layouts.adminlayout')
@section('content')
    @if (session('success'))
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-primary bottom-0 end-0 show" role="alert"
            aria-live="assertive" aria-atomic="true" data-delay="2000">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Thông báo</div>
                <small>Vừa xong</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    @endif
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><a href="/admin/sanpham" class="text-muted fw-light">Sản phẩm </a>/
            {{ $title }}
        </h4>
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0"></h5>
                        {{-- <small class="text-muted float-end">Default label</small> --}}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/sanpham-save" onsubmit="return validateForm()"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $sanpham->product_id }}">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Tên sản phẩm</label>
                                <div class="col-sm-10">
                                    <input type="text" name="product_name" class="form-control" id="product_name"
                                        placeholder="Tên sản phẩm" value="{{ $sanpham->product_name }}" />
                                    <div class="form-text text-danger" id="check-product_name"></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Giá bán</label>
                                <div class="col-sm-10">
                                    <input type="number" name="price" class="form-control" id="price"
                                        placeholder="Giá sản phẩm" value="{{ $sanpham->price }}" />
                                    <div class="form-text text-danger" id="check-price"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Danh mục</label>
                                <div class="col-sm-10">
                                    <select name="ma_danhmuc" class="form-select" id='testti'>

                                    </select>
                                    <div class="form-text text-danger" id="check-danhmuc"></div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Mô tả</label>
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control" rows="3" placeholder="Mô tả sản phẩm">{{ $sanpham->description }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Ảnh</label>
                                <div class="col-sm-10">
                                    <input type="file" name="images[]" accept="image/*" class="form-control"
                                        placeholder="Chọn nhiều ảnh" multiple />
                                    <br>
                                    @foreach ($photos as $photo)
                                        <img src="{{ asset('uploads/' . $photo->photo_link) }}" height="60px"
                                            width="auto">
                                    @endforeach
                                </div>


                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                                    <button type="button" onclick="xoaSP({{ $sanpham->product_id }})"
                                        class="btn btn-danger">Xóa</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <script>
        var csrfToken = "{{ csrf_token() }}";
        var danhmuc = [];
        var danhmuc = {!! json_encode($danhmuc) !!};
    </script>
    <script src="{{ asset('assets/sanpham.js') }}"></script>
@endsection
