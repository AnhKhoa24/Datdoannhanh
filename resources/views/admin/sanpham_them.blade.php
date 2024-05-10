@extends('layouts.adminlayout')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><a href="/admin/sanpham" class="text-muted fw-light">Sản phẩm </a>/ thêm sản phẩm </h4>
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Thêm mới sản phẩm</h5>
                        {{-- <small class="text-muted float-end">Default label</small> --}}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/sanpham-them" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Tên sản phẩm</label>
                                <div class="col-sm-10">
                                    <input type="text" name="product_name" class="form-control" id="product_name"
                                        placeholder="Tên sản phẩm" />
                                    <div class="form-text text-danger" id="check-product_name"></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Giá bán</label>
                                <div class="col-sm-10">
                                    <input type="number" name="price" class="form-control" id="price"
                                        placeholder="Giá sản phẩm" />
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
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Ảnh</label>
                                <div class="col-sm-10">
                                    <input type="file" name="images[]" accept="image/*" class="form-control"
                                        placeholder="Chọn nhiều ảnh" multiple />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Mô tả</label>
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control" rows="3" placeholder="Mô tả sản phẩm"></textarea>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitBtn" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var csrfToken = "{{ csrf_token() }}";
        var danhmuc = [];
    </script>
    <script src="{{ asset('assets/sanpham.js') }}"></script>
@endsection
