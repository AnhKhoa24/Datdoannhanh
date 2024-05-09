<?php

namespace App\Http\Controllers;

use App\Models\Danhmuc;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = "";
        if ($request->search) {
            $search = $request->search;
        }
        $sanphams = Product::selectRaw(
            'products.product_name,
            products.product_id,
            products.price,
            products.description,
            danhmucs.tendanhmuc,
            IFNULL(MAX(photos.photo_link), "nophoto.jpg") AS photo_link'
        )
            ->Join('danhmucs', 'danhmucs.ma_danhmuc', 'products.ma_danhmuc')
            ->leftJoin('photos', 'products.product_id', 'photos.product_id')
            ->where('products.product_name', 'LIKE', "%$search%")
            ->orWhere('danhmucs.tendanhmuc', 'LIKE', "%$search%")
            ->groupBy('products.product_id')
            ->paginate(8);
        $sotrang = $sanphams->lastPage();
        $trang = $sanphams->currentPage();


        $mess = [];
        $sl = 0;
        if (Auth::user()) {
            $mess = DB::table('messages')->where('user_id', Auth::user()->id)
                ->where('kind',1)
                ->orderByDesc('created_at')
                ->get();
            $sl = count($mess);
        }

        if ($request->ajax()) {
            return [
                'list' => view('data', ['sanphams' => $sanphams,])->render(),
                'trang' => view('linkpages', ['sotrang' => $sotrang, 'trang' => $trang])->render(),
            ];
        }

        return view('index', [
            'sanphams' => $sanphams,
            'sotrang' => $sotrang,
            'trang' => $trang,
            'tinnhans' => $mess,
            'sl' => $sl
        ]);
    }
    public function getName()
    {
        $tensp = Product::all();
        $danhmuc = Danhmuc::all();
        $data = [];
        foreach ($tensp as $item) {
            $data[] = $item->product_name;
        }
        foreach ($danhmuc as $item) {
            $data[] = $item->tendanhmuc;
        }

        return $data;
    }
    public function chitiet($product_id)
    {
        $sanpham = DB::table('products')->join('danhmucs','danhmucs.ma_danhmuc','products.ma_danhmuc')
        ->where('products.product_id',$product_id)->first();

        $photos = DB::table('photos')
            ->join('products', 'photos.product_id', 'products.product_id')
            ->where('products.product_id', $product_id)
            ->get();
        $mess = [];
        $sl = 0;
        if (Auth::user()) {
            $mess = DB::table('messages')->where('user_id', Auth::user()->id)
                ->where('kind',1)
                ->orderByDesc('created_at')
                ->get();
            $sl = count($mess);
        }
        return view('chitiet', [
            'tinnhans' => $mess,
            'sl' => $sl,
            'photos'=>$photos,
            'sanpham'=>$sanpham,
        ]);
    }
}
