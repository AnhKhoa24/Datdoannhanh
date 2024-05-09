<?php

namespace App\Http\Controllers;

use App\Models\Danhmuc;
use App\Models\Message;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                ->where('kind', 1)
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
    public function chitiet($product_id, Request $request)
    {
        $sanpham = DB::table('products')->join('danhmucs', 'danhmucs.ma_danhmuc', 'products.ma_danhmuc')
            ->where('products.product_id', $product_id)->first();

        $photos = DB::table('photos')
            ->join('products', 'photos.product_id', 'products.product_id')
            ->where('products.product_id', $product_id)
            ->get();
        $mess = [];
        $sl = 0;
        if (Auth::user()) {
            $mess = DB::table('messages')->where('user_id', Auth::user()->id)
                ->where('kind', 1)
                ->orderByDesc('created_at')
                ->get();
            $sl = count($mess);
        }

        $danhgias = DB::table('rates')
            ->where('product_id', $product_id)
            ->orderByDesc('created_at')
            ->paginate(3);
        $sosaosp = $this->getRate($product_id);
        if ($request->ajax()) {
            return [
                'loadrate' => view('rating', ['sosao' => $sosaosp,])->render(),
                'loadreview' => view('reviews', ['danhgias' => $danhgias])->render(),
                'loadreform' => view('reviewform', ['sanpham' => $sanpham])->render(),
                'loadfre' => view('fastreview', ['sosao' => $sosaosp,])->render(),
            ];
        }
        return view('chitiet', [
            'tinnhans' => $mess,
            'sl' => $sl,
            'photos' => $photos,
            'sanpham' => $sanpham,
            'danhgias' => $danhgias,
            'sosao' => $sosaosp
        ]);
    }
    public function danhgia(Request $request)
    {
        $rate = new Rate();
        $rate->product_id = $request->product_id;
        $rate->content = $request->content;
        $rate->sosao = $request->sosao;
        $rate->rater = $request->name;
        $rate->save();
        return 0;
    }

    private function getRate($product_id)
    {
        $sodanhgia = DB::table('rates')
        ->selectRaw('COALESCE(COUNT(*), 0) as sdg')
        ->where('product_id', $product_id)
        ->first();
        $sosaosp = DB::table('rates')
            ->selectRaw('COALESCE(ROUND(AVG(sosao), 1), 0) as so')
            ->where('product_id', $product_id)
            ->first();
        $sao_5 = DB::table('rates')
            ->selectRaw('COALESCE(COUNT(sosao), 0) as so')
            ->where('product_id', $product_id)
            ->where('sosao', 5)
            ->first();
        $sao_4 = DB::table('rates')
            ->selectRaw('COALESCE(COUNT(sosao), 0) as so')
            ->where('product_id', $product_id)
            ->where('sosao', 4)
            ->first();
        $sao_3 = DB::table('rates')
            ->selectRaw('COALESCE(COUNT(sosao), 0) as so')
            ->where('product_id', $product_id)
            ->where('sosao', 3)
            ->first();
        $sao_2 = DB::table('rates')
            ->selectRaw('COALESCE(COUNT(sosao), 0) as so')
            ->where('product_id', $product_id)
            ->where('sosao', 2)
            ->first();
        $sao_1 = DB::table('rates')
            ->selectRaw('COALESCE(COUNT(sosao), 0) as so')
            ->where('product_id', $product_id)
            ->where('sosao', 1)
            ->first();

        $danhgia = [
            'sosao' => $sosaosp->so,
            'sao_5' => $sao_5->so,
            'sao_4' => $sao_4->so,
            'sao_3' => $sao_3->so,
            'sao_2' => $sao_2->so,
            'sao_1' => $sao_1->so,
            'sodanhgia'=>$sodanhgia->sdg,
        ];
        return $danhgia;
    }
}
