<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sanphams = DB::table('products')->join('danhmucs', 'products.ma_danhmuc', 'danhmucs.ma_danhmuc')->paginate(8);
        $sotrang = $sanphams->lastPage();
        $trang = $sanphams->currentPage();
        return view('admin.sanpham', [
            'sanphams' => $sanphams,
            'sotrang' => $sotrang,
            'trang' => $trang,
            'title' => "Sản phẩm",
        ]);
    }
    public function create()
    {
        $danhmucs = DB::table('danhmucs')->get();
        return view('admin.sanpham_them', [
            'title' => "Thêm mới sản phẩm",
            'danhmucs' => $danhmucs
        ]);
    }
    public function laydanhmuc(Request $request)
    {
        $danhmucs = [];
        if ($search = $request->name) {
            $danhmucs = DB::table('danhmucs')->where('tendanhmuc', 'LIKE', "%$search%")->get();
        } else {
            $danhmucs = DB::table('danhmucs')->get();
        }
        return response()->json($danhmucs);
    }
    public function store(Request $request)
    {

        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'ma_danhmuc' => 'required',
        ]);
        $product = new Product();
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->ma_danhmuc = $request->ma_danhmuc;
        $product->save();

       
        //Xử lý ảnh
        if ($request->images) {
            foreach ($request->images as $value) {
                $imageName = time() . '_' . $value->getClientOriginalName();
                $value->move(public_path('uploads'), $imageName);
                $imageNams[] = $imageName;
                $photo = new Photo();
                $photo->photo_link = $imageName;
                $photo->product_id = $product->id;
                $photo->save();
            }
        }

        return redirect('/admin/sanpham')->with('success',"Thêm thành công sản phẩm");
    }
}
