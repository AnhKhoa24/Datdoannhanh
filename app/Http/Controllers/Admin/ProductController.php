<?php

namespace App\Http\Controllers\Admin;

use App\Events\ProductDeleteEvent;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $search = "";
        if ($request->search) {
            $search = $request->search;
        }
        $sanphams = DB::table('products')->join('danhmucs', 'products.ma_danhmuc', 'danhmucs.ma_danhmuc')
            ->where('products.product_name', 'LIKE', "%$search%")
            ->paginate(8);
        $sotrang = $sanphams->lastPage();
        $trang = $sanphams->currentPage();
        if ($request->ajax()) {
            return [
                'data' => view('admin.sanpham_data', ['sanphams' => $sanphams])->render(),
                'paginate' => view('admin.sanpham_trang', ['sotrang' => $sotrang, 'trang' => $trang])->render(),
            ];
        }
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
        try {
            $product->save();
        } catch (\Exception $e) {
            return redirect('/admin/sanpham')->with("error", "Có lỗi xảy ra");
        }


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
        // return redirect('/admin/sanpham')->with('success', 'Thêm thành công!');
        return 1;
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

        $product = Product::find($request->product_id);
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->ma_danhmuc = $request->ma_danhmuc;
        $product->description = $request->description;
        $product->save();

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

        return redirect('/admin/sanpham-xemthem/' . $request->product_id)->with('success', "Bạn vừa cập nhật thành công!");
    }

    public function xoa(Request $request)
    {
        $check = DB::table('orderdetails')->where('product_id',$request->product_id)->get();
        if(count($check) > 0)
        {
            return 0;
        }
        //Xóa ảnh của sản phẩm
        $photos = DB::table('photos')->where('product_id', $request->product_id)->get();
        foreach ($photos as $photo) {
            $fileanh = public_path('uploads') . '/' . $photo->photo_link;
            if (File::exists($fileanh)) {
                File::delete($fileanh);
            }
        }
        //Xóa link ảnh trên DB
        DB::table('photos')->where('product_id', $request->product_id)->delete();
        //Xóa product
        //Xóa link ảnh trên DB
        DB::table('photos')->where('product_id', $request->product_id)->delete();
        //Xóa product
        $product = Product::find($request->product_id);
        $product_bk = $product;
        $product->delete();

        try {
            event(new ProductDeleteEvent($product_bk));
        } catch (\Exception $e) {
        }
        return 1;
    }

     //Thống kê ở đây Khoa
     public function thongKe(Request $request)
     {
         $fromDate = $request->input('from_date');
         $toDate = $request->input('to_date');
         $quantityStats = $this->getQuantityStatistics($fromDate, $toDate);
         $revenueStats = $this->getRevenueStatistics($fromDate, $toDate);
 
 
         return view('admin.statistical', compact('quantityStats', 'revenueStats'));
     }
     private function getQuantityStatistics($fromDate, $toDate)
     {
         $query = DB::table('orderdetails')
             ->join('products', 'orderdetails.product_id', '=', 'products.product_id')
             ->join('orders', 'orderdetails.order_id', '=', 'orders.order_id')
             ->select('products.product_name', DB::raw('SUM(orderdetails.quantity) as quantity'))
             ->where('orders.status', '=', 6)
             ->groupBy('products.product_name');
 
         if ($fromDate && $toDate) {
             $query->whereBetween('orderdetails.created_at', [$fromDate, $toDate]);
         }
         else{
 
         }
 
         return $query->get();
     }
 
     private function getRevenueStatistics($fromDate, $toDate)
     {
         $query = DB::table('orderdetails')
             ->join('products', 'orderdetails.product_id', '=', 'products.product_id')
             ->join('orders', 'orderdetails.order_id', '=', 'orders.order_id')
             ->select('products.product_name', DB::raw('SUM(orderdetails.quantity * products.price) as revenue'))
             ->where('orders.status', '=', 6)
             ->limit(5)
             ->groupBy('products.product_name');
 
         if ($fromDate && $toDate) {
             $query->whereBetween('orderdetails.created_at', [$fromDate, $toDate]);
         }
 
         return $query->get();
     }
}
