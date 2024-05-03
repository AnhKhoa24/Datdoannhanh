<?php

namespace App\Http\Controllers\Admin;

use App\Events\ThongBaoEvent;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Stmt\TryCatch;

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
                $photo->product_id = $product->product_id;
                $photo->save();
            }
        }
        return redirect('/admin/sanpham')->with('success', 'Thêm thành công!');
    }

    public function xemthem($product_id)
    {
        $sanpham = DB::table('products')->where('product_id', $product_id)->first();
        $danhmuc = DB::table('danhmucs')->join('products', 'danhmucs.ma_danhmuc', 'products.ma_danhmuc')
            ->where('product_id', $product_id)->get();
        $photos = DB::table('photos')->join('products', 'photos.product_id', 'products.product_id')
            ->where('photos.product_id', $product_id)->get();
        return view('admin.sanpham_chitiet', [
            'sanpham' => $sanpham,
            'title' => $sanpham->product_name,
            'danhmuc' => $danhmuc,
            'photos' => $photos,
        ]);
    }
    public function savechanges(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            'ma_danhmuc' => 'required',
        ]);
        DB::table('products')->where('product_id', $request->product_id)->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'ma_danhmuc' => $request->ma_danhmuc,
            'description' => $request->description,
        ]);

        //Xử lý ảnh, nếu người dùng tải ảnh mới
        if ($request->images) {
            $photos = DB::table('photos')->where('product_id', $request->product_id)->get();
            //Xóa ảnh cũ
            foreach ($photos as $photo) {
                $fileanh = public_path('uploads') . '/' . $photo->photo_link;
                if (File::exists($fileanh)) {
                    File::delete($fileanh);
                }
            }
            //Xóa trên db
            DB::table('photos')->where('product_id', $request->product_id)->delete();

            //Tải ảnh mới
            foreach ($request->images as $value) {
                $imageName = time() . '_' . $value->getClientOriginalName();
                $value->move(public_path('uploads'), $imageName);
                $imageNams[] = $imageName;
                $photo = new Photo();
                $photo->photo_link = $imageName;
                $photo->product_id = $request->product_id;
                $photo->save();
            }
        }


        return redirect('/admin/sanpham-xemthem/' . $request->product_id);
    }
}
