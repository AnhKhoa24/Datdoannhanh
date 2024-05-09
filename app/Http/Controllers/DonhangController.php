<?php

namespace App\Http\Controllers;

use App\Events\HuyDonEvent;
use App\Models\Message;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonhangController extends Controller
{
    public function index()
    {
        $sp = DB::table('products')
            ->selectRaw('products.*, IFNULL(MAX(photos.photo_link),"nophoto.jpg") AS photo_link')
            ->leftJoin('photos', 'products.product_id', 'photos.product_id')
            ->groupBy('products.product_id')
            ->get();
        $od_sp = DB::table('orderdetails')
            ->select('orders.*', 'orderdetails.product_id', 'orderdetails.quantity', 'orderdetails.price', 'orderdetails.total')
            ->join('orders', 'orderdetails.order_id', 'orders.order_id')
            ->where('orders.user_id', Auth::user()->id)
            ->where('orders.status', '>', '0')
            ->where('orders.status', '<', '6')
            ->get();

        $order_sp = [];

        foreach ($od_sp as $item) {
            $product = collect($sp)->firstWhere('product_id', $item->product_id);
            $addpr = [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'photo_link' => $product->photo_link,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->total
            ];
            if ($product) {
                $order_sp[] = [
                    'order_id' => $item->order_id,
                    'products' => $addpr,
                ];
            }
        }

        $donhangs = DB::table('orders')
            ->where('user_id', Auth::user()->id)
            ->where('orders.status', '>', '0')
            ->where('orders.status', '<', '6')
            ->orderBy('created_at', 'desc')
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
        return view('donhang', [
            'donhangs' => $donhangs,
            'sanphams' => $order_sp,
            'tinnhans' => $mess,
            'sl' => $sl
        ]);
    }
    public function chitiet($id)
    {
        $order = DB::table('orders')->where('order_id', $id)->first();
        $sp = DB::table('products')
            ->selectRaw('products.*, IFNULL(MAX(photos.photo_link),"nophoto.jpg") AS photo_link')
            ->leftJoin('photos', 'products.product_id', 'photos.product_id')
            ->join('orderdetails', 'orderdetails.product_id', 'products.product_id')
            ->where('orderdetails.order_id', $id)
            ->groupBy('products.product_id')
            ->get();
        $orderdetail = DB::table('orderdetails')
            ->where('order_id', $id)
            ->get();
        $order_sp = [];
        foreach ($orderdetail as $item) {
            $product = collect($sp)->firstWhere('product_id', $item->product_id);
            $addpr = [
                'order_id' => $item->order_id,
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'photo_link' => $product->photo_link,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->total
            ];
            $order_sp[] = $addpr;
        }
        $mess = [];
        $sl = 0;
        if (Auth::user()) {
            $mess = DB::table('messages')->where('user_id', Auth::user()->id)
                ->where('kind', 1)
                ->orderByDesc('created_at')
                ->get();
            $sl = count($mess);
        }
        return view('chitietdonhang', [
            'donhang' => $order,
            'sanphams' => $order_sp,
            'tinnhans' => $mess,
            'sl' => $sl,
        ]);
    }
    public function huydon(Request $request)
    {
        $timdon = DB::table('orders')->where('order_id', $request->order_id)->first();
        $result = 0;
        if ($timdon->status == 1) {
            //hủy thành công
            DB::table('orders')->where('order_id', $request->order_id)->update([
                'status' => -1,
            ]);
            $result = 1;
        } else if ($timdon->status >= 2) {

            $check = DB::table('messages')->where('more', $request->order_id)->first();
            if ($check == null) {
                $current_time = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
                $formatted_time = $current_time->format("Y-m-d H:i:s");
                $newmess = new Message();
                $newmess->user_id = $timdon->user_id;
                $newmess->content = "Yêu cầu hủy đơn hàng";
                $newmess->sender = Auth::user()->name;
                $newmess->kind = 2;
                $newmess->more = $request->order_id;
                $newmess->created_at = $formatted_time;
                $newmess->save();
            }
        }
        try {
            event(new HuyDonEvent('Yêu cầu hủy đơn hàng: ' . $request->order_id));
        } catch (\Exception $e) {
        }

        return $result;
    }
    public function lichsudonhang()
    {
        $sp = DB::table('products')
            ->selectRaw('products.*, IFNULL(MAX(photos.photo_link),"nophoto.jpg") AS photo_link')
            ->leftJoin('photos', 'products.product_id', 'photos.product_id')
            ->groupBy('products.product_id')
            ->get();
        $od_sp = DB::table('orderdetails')
            ->select('orders.*', 'orderdetails.product_id', 'orderdetails.quantity', 'orderdetails.price', 'orderdetails.total')
            ->join('orders', 'orderdetails.order_id', 'orders.order_id')
            ->where('orders.user_id', Auth::user()->id)
            ->where('orders.status', '6')
            ->get();

        $order_sp = [];

        foreach ($od_sp as $item) {
            $product = collect($sp)->firstWhere('product_id', $item->product_id);
            $addpr = [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'photo_link' => $product->photo_link,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->total
            ];
            if ($product) {
                $order_sp[] = [
                    'order_id' => $item->order_id,
                    'products' => $addpr,
                ];
            }
        }

        $donhangs = DB::table('orders')
            ->where('user_id', Auth::user()->id)
            ->where('orders.status','6')
            ->orderBy('created_at', 'desc')
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
        return view('lichsudonhang', [
            'donhangs' => $donhangs,
            'sanphams' => $order_sp,
            'tinnhans' => $mess,
            'sl' => $sl
        ]);
    }
    public function dahuy()
    {
        $sp = DB::table('products')
            ->selectRaw('products.*, IFNULL(MAX(photos.photo_link),"nophoto.jpg") AS photo_link')
            ->leftJoin('photos', 'products.product_id', 'photos.product_id')
            ->groupBy('products.product_id')
            ->get();
        $od_sp = DB::table('orderdetails')
            ->select('orders.*', 'orderdetails.product_id', 'orderdetails.quantity', 'orderdetails.price', 'orderdetails.total')
            ->join('orders', 'orderdetails.order_id', 'orders.order_id')
            ->where('orders.user_id', Auth::user()->id)
            ->where('orders.status', '-1')
            ->get();

        $order_sp = [];

        foreach ($od_sp as $item) {
            $product = collect($sp)->firstWhere('product_id', $item->product_id);
            $addpr = [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'photo_link' => $product->photo_link,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->total
            ];
            if ($product) {
                $order_sp[] = [
                    'order_id' => $item->order_id,
                    'products' => $addpr,
                ];
            }
        }

        $donhangs = DB::table('orders')
            ->where('user_id', Auth::user()->id)
            ->where('orders.status','-1')
            ->orderBy('created_at', 'desc')
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
        return view('dahuy', [
            'donhangs' => $donhangs,
            'sanphams' => $order_sp,
            'tinnhans' => $mess,
            'sl' => $sl
        ]);
    }
    public function xoadonhang(Request $request)
    {
        DB::table('orderdetails')->where('order_id',$request->order_id)->delete();
        DB::table('orders')->where('order_id',$request->order_id)->delete();
        return 1;
    }
}
