<?php

namespace App\Http\Controllers;

use App\Events\ThongBaoEvent;
use App\Mail\OrderShipped;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function index()
    {       
        return view('cart');
    }


    public function addToCart(Request $request)
    {
        $in4sp = Product::find($request->product_id);
        $photo = DB::table('photos')
            ->select('product_id', DB::raw('MAX(photo_link) AS photo_link'))
            ->where('product_id', $request->product_id)
            ->groupBy('product_id')
            ->first();
        $photo_link = "nophoto.jpg";
        if ($photo) {
            $photo_link =  $photo->photo_link;
        }

        $quantity = 1;
        if($request->quantity)
        {
            $quantity = $request->quantity;
        }
        $product = [
            'product_id' => $request->product_id,
            'product_name' => $in4sp->product_name,
            'price' => $in4sp->price,
            'photo_link' => $photo_link,
            'quantity' => $quantity,
        ];

        $cart = session('cart', []);
        $key = array_search($product['product_id'], array_column($cart, 'product_id'));
        if ($key !== false) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[] = $product;
        }
        session(['cart' => $cart]);

        if ($request->ajax()) {
            return [
                'giohang' => view('minicart')->render(),
            ];
        }
        return 1;
    }
    public function delToCart(Request $request)
    {
        $product_id = $request->product_id;
        $cart = session('cart', []);
        $cart = array_filter($cart, function ($item) use ($product_id) {
            return $item['product_id'] != $product_id;
        });
        session(['cart' => $cart]);
        if ($request->ajax()) {
            return [
                'giohang' => view('minicart')->render(),
            ];
        }
        return 1;
    }
    public function checkout()
    {
        $name = Auth::user()->name;
        $mess = [];
        $sl = 0;
        if(Auth::user())
        {
            $mess = DB::table('messages')->where('user_id',Auth::user()->id)
            ->where('kind',1)
            ->orderByDesc('created_at')
            ->get();
            $sl = count($mess);
        }  
        return view('checkout', [
            'name' => $name,
            'tinnhans'=>$mess,
            'sl'=>$sl,
        ]);
    }
    public function ordering(Request $request)
    {
        if (sizeof(session('cart', [])) < 1) {
            return 0;
        }
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->status = 1;
        $order->recipient_name = $request->name;
        $order->recipient_phone = $request->phone;
        $order->recipient_address = $request->address;
        $order->note = $request->note;
        $order->payment = $request->payment;
        $order->save();
        $cart = session('cart', []);
        foreach ($cart as $item) {
            $ordetail = new Orderdetail();
            $ordetail->product_id = $item['product_id'];
            $ordetail->order_id = $order->order_id;
            $ordetail->quantity = $item['quantity'];
            $ordetail->price = $item['price'];
            $ordetail->total = $item['quantity'] * $item['price'];
            $ordetail->save();
        }
        session()->forget('cart');

        $username = 'Khoa nè con';
        Mail::to('anhkhoa.24052003@gmail.com')->send(new OrderShipped($username));
        try {
            event(new ThongBaoEvent());
        } catch (\Exception $e) {
        }

        return 1;
    }
}
