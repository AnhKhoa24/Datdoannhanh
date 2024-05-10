<?php

use App\Http\Controllers\Admin\DanhmucController as AdminDanhmucController;
use App\Http\Controllers\Admin\DonhangController as AdminDonHangController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DonhangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//GET TỈNH QUẬN/HUYỆN PHƯỜNG/XÃ

Route::post('/get-tinh',[HomeController::class,'getTinh'])->middleware('auth');
Route::post('/get-qh',[HomeController::class,'getQH'])->middleware('auth');
Route::post('/get-px',[HomeController::class,'getPX'])->middleware('auth');

//-client
Route::get('/', [ProductController::class, 'index']);
Route::get('chitiet/{id}',[ProductController::class,'chitiet']);
Route::get('/get-tag-name', [ProductController::class, 'getName']);
Route::get('/giohang', [CartController::class, 'index'])->middleware('auth');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->middleware('auth');
Route::post('/delete-to-cart', [CartController::class, 'delToCart'])->middleware('auth');
Route::get('/checkout', [CartController::class, 'checkout'])->middleware('auth');
Route::post('/checkout', [CartController::class, 'ordering'])->middleware('auth');
Route::get('/donhang',[DonhangController::class,'index'])->middleware('auth');
Route::post('/xoatinnhan',[HomeController::class,'xoatinnhan'])->middleware('auth');
Route::post('/loadtinnhan',[HomeController::class,'loadtinnhan'])->middleware('auth');
Route::get('/donhangchitiet/{id}',[DonhangController::class,'chitiet'])->middleware('auth');
Route::post('/yeucauhuydon',[DonhangController::class,'huydon'])->middleware('auth');
Route::post('/danhgia',[ProductController::class,'danhgia'])->middleware('auth');
Route::get('/canhan',[HomeController::class,'canhan'])->middleware('auth');
Route::post('/kiemtra-user',[HomeController::class,'kiemtra'])->middleware('auth');
Route::post('/huytaikhoan',[HomeController::class,'huytaikhoan'])->middleware('auth');
Route::get('/lichsudonhang',[DonhangController::class,'lichsudonhang'])->middleware('auth');
Route::get('/dahuy',[DonhangController::class,'dahuy'])->middleware('auth');
Route::post('/xoadonhang',[DonhangController::class,'xoadonhang'])->middleware('auth');

///----end client----
Route::get('/home', [HomeController::class,'index'])->middleware('auth');
Route::get('/check', [HomeController::class,'check']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::controller(AdminHomeController::class)->group(function(){
//     Route::get('admin','index')->middleware('auth','admin');
// });

Route::get('admin',[AdminProductController::class,'thongke'])->middleware('auth','admin');

Route::controller(AdminProductController::class)->group(function(){
    Route::get('admin/sanpham','index')->middleware('auth', 'admin');
    Route::get('admin/sanpham-them','create')->middleware('auth','admin');
    Route::post('admin/sanpham-them','store')->middleware('auth','admin');
    Route::post('/admin/laydanhmuc','laydanhmuc')->middleware('auth','admin');
    Route::get('/admin/sanpham-xemthem/{id}','xemthem')->middleware('auth','admin');
    Route::post('/admin/sanpham-save','savechanges')->middleware('auth','admin');
    Route::post('/admin/sanpham-xoa','xoa')->middleware('auth','admin');
});
Route::controller(AdminDanhmucController::class)->group(function()
{
    Route::get('admin/danhmuc','index')->middleware('auth','admin');
    Route::post('admin/danhmuc','store')->middleware('auth','admin');
    Route::post('/admin/editdanhmuc','savechange')->middleware('auth','admin');
    Route::post('/admin/xoadanhmuc','xoadanhmuc')->middleware('auth','admin');
    Route::post('/admin/danhmuc/getname','getname')->middleware('auth','admin');
});

Route::controller(AdminDonHangController::class)->group(function(){
    Route::get('/admin/donhang','index')->middleware('auth','admin');
    Route::post('/admin/donhang/duyetnhanh','duyetnhanh')->middleware('auth','admin');
    Route::get('/admin/donhang-xemthem/{id}','xemthem')->middleware('auth','admin');
    Route::post('/doisoluong', 'doisoluong')->middleware('auth','admin');
    Route::post('/admin/donhang-savechages','savechanges')->middleware('auth','admin');
    Route::get('/admin/yeucauhuydon','yeucauhuydon')->middleware('auth','admin');
    Route::post('/admin/duyetyeucau','duyetyeucau')->middleware('auth','admin');
    Route::post('/admin/huydonhang','huydonhang')->middleware('auth','admin');
    Route::post('/admin/tuchoiyeucau','tuchoiyeucau')->middleware('auth','admin');
});

require __DIR__.'/auth.php';
