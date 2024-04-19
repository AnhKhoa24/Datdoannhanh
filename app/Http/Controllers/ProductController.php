<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{  
    public function index()
    {
        $products = DB::table('products')->get();
        return view('sanpham.index',[
            'products'=>$products
        ]);
    }

}
