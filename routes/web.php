<?php

use App\Http\Controllers\Admin\DanhmucController as AdminDanhmucController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProductController::class, 'index']);

Route::get('/home', [HomeController::class,'index'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(AdminHomeController::class)->group(function(){
    Route::get('admin','index')->middleware('auth','admin');
});
Route::controller(AdminProductController::class)->group(function(){
    Route::get('admin/sanpham','index')->middleware('auth', 'admin');
});
Route::controller(AdminDanhmucController::class)->group(function()
{
    Route::get('admin/danhmuc','index')->middleware('auth','admin');
    Route::post('admin/danhmuc','store')->middleware('auth','admin');
});

require __DIR__.'/auth.php';
