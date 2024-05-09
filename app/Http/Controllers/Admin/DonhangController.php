<?php

namespace App\Http\Controllers\Admin;

use App\Events\ThongBaoClientEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Order;
use App\Models\Orderdetail;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonhangController extends Controller
{
    public function index(Request $request)
    {
        $donhangs = DB::table('orders')
            ->select('orders.*', 'users.name', 'users.email')
            ->join('users', 'orders.user_id', 'users.id')
            ->where('status','>','0')
            ->orderBy('orders.status', 'asc')
            ->paginate(5);
        $sotrang = $donhangs->lastPage();
        $trang = $donhangs->currentPage();
        if ($request->ajax()) {

            if ($request->ngay != null & $request->trangthai == null) {
                $donhangs = DB::table('orders')
                    ->select('orders.*', 'users.name', 'users.email')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->whereDate('orders.created_at', $request->ngay)
                    ->where('status','>','0')
                    ->orderBy('orders.status', 'asc')
                    ->paginate(5);
                $sotrang = $donhangs->lastPage();
                $trang = $donhangs->currentPage();
            } else if ($request->ngay == null & $request->trangthai != null) {
                $donhangs = DB::table('orders')
                    ->select('orders.*', 'users.name', 'users.email')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->where('orders.status', $request->trangthai)
                    ->where('status','>','0')
                    ->orderBy('orders.status', 'asc')
                    ->paginate(5);
                $sotrang = $donhangs->lastPage();
                $trang = $donhangs->currentPage();
            } else if ($request->ngay != null & $request->trangthai != null) {
                $donhangs = DB::table('orders')
                    ->select('orders.*', 'users.name', 'users.email')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->where('orders.status', $request->trangthai)
                    ->where('status','>','0')
                    ->whereDate('orders.created_at', $request->ngay)
                    ->orderBy('orders.status', 'asc')
                    ->paginate(5);
                $sotrang = $donhangs->lastPage();
                $trang = $donhangs->currentPage();
            } else if ($request->order_id != null & $request->ngay == null & $request->trangthai == null) {
                $donhangs = DB::table('orders')
                    ->select('orders.*', 'users.name', 'users.email')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->where('orders.order_id', $request->order_id)
                    ->where('status','>','0')
                    ->orderBy('orders.status', 'asc')
                    ->paginate(5);
                $sotrang = $donhangs->lastPage();
                $trang = $donhangs->currentPage();
            }
            return [
                'data' => view('admin.donhang_data', ['donhangs' => $donhangs])->render(),
                'paginate' => view('admin.donhang_trang', ['sotrang' => $sotrang, 'trang' => $trang])->render(),
            ];
        }
        return view('admin.donhang', [
            'donhangs' => $donhangs,
            'sotrang' => $sotrang,
            'trang' => $trang,
            'title' => "Đơn hàng",
        ]);
    }
    public function duyetnhanh(Request $request)
    {
        if ($request->status >= 6) {
            return 0;
        }
        $newstatus = $request->status + 1;
        try {
            DB::table('orders')->where('order_id', $request->order_id)->update([
                'status' => $newstatus,
            ]);
        } catch (\Exception $e) {
            return 0;
        }

        $order = Order::find($request->order_id);
        $tt = "";
        $tentrangthai = "Đang xác nhận đơn hàng";
        switch ($newstatus) {
            case 2:
                $tt = "Đơn hàng: ".$request->order_id." đã được xác nhận!";
                $tentrangthai = "Đã xác nhận đơn hàng";
                break;
            case 3:
                $tt = "Đơn hàng: ".$request->order_id." đang được chuẩn bị!";
                $tentrangthai = "Đang chuẩn bị hàng";
                break;
            case 4:
                $tt = "Đơn hàng: ".$request->order_id." đang chuẩn bị xong!";
                $tentrangthai = "Đã chuẩn bị đơn hàng";
                break;
            case 5:
                $tt = "Đơn hàng: ".$request->order_id." đang được giao!";
                $tentrangthai = "Đang giao";
                break;
            case 6:
                $tt = "Đơn hàng: ".$request->order_id." đã giao thành công!";
                $tentrangthai = "Đã giao thành công";
                break;
        }
        $current_time = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $formatted_time = $current_time->format("Y-m-d H:i:s");
        $newmess = new Message();
        $newmess->user_id = $order->user_id;
        $newmess->content = $tt;
        $newmess->sender = Auth::user()->name;
        $newmess->created_at = $formatted_time;
        $newmess->save();
        $guive = [
            'order_id'=>$order->order_id,
            'user_id'=>$order->user_id,
            'trangthai'=>$tentrangthai,
            'status'=>$order->status
        ];
        event(new ThongBaoClientEvent($tt, $guive ));

        return $newstatus;
    }
    public function xemthem($order_id)
    {
        $order = DB::table('orders')
            ->select('orders.*', 'users.id', 'users.name', 'users.email')
            ->join('users', 'orders.user_id', 'users.id')
            ->where('order_id', $order_id)
            ->first();
        $products = DB::table('products')
            ->selectRaw('products.*, IFNULL(MAX(photos.photo_link),"nophoto.jpg") AS photo_link')
            ->leftJoin('photos', 'products.product_id', 'photos.product_id')
            ->join('orderdetails', 'products.product_id', 'orderdetails.product_id')
            ->where('order_id', $order_id)
            ->groupBy('products.product_id')
            ->get();
        $ordetails = DB::table('orderdetails')->where('order_id', $order_id)->get();
        $product_order = [];
        foreach ($ordetails as $item) {
            $pd = collect($products)->firstWhere('product_id', $item->product_id);
            if ($pd) {
                $product_order[] = [
                    'product_id' => $item->product_id,
                    'product_name' => $pd->product_name,
                    'photo_link' => $pd->photo_link,
                    'default_price' => $pd->price,
                    'buy_price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->total
                ];
            }
        }
        return view('admin.chitiet_donhang', [
            'order' => $order,
            'sanphams' => $product_order,
            'title' => "Đơn hàng: " . $order->order_id
        ]);
    }
    public function doisoluong(Request $request)
    {
        DB::table('orderdetails')
            ->where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->update([
                'quantity' => $request->quantity,
                'total' => $request->total
            ]);
        return 1;
    }
    public function savechanges(Request $request)
    {
        DB::table('orders')->where('order_id', $request->order_id)
            ->update([
                'status' => $request->status,
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'recipient_address' => $request->recipient_address,
                'payment' => $request->payment
            ]);

        $order = Order::find($request->order_id);
        $tt = Auth::user()->name . " đã chỉnh sửa đơn hàng: " . $request->order_id . " !!";
        $current_time = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $formatted_time = $current_time->format("Y-m-d H:i:s");
        $newmess = new Message();
        $newmess->user_id = $order->user_id;
        $newmess->content = $tt;
        $newmess->sender = Auth::user()->name;
        $newmess->created_at = $formatted_time;
        $newmess->save();

        try {
            event(new ThongBaoClientEvent($tt, $order));
        } catch (\Exception $e) {
        }
        return 1;
    }
    public function yeucauhuydon(Request $request)
    {
        $search = "";
        if($request->search)
        {
            $search = $request->search;
        }
        $yeucaus = DB::table('messages')
        ->where('kind',2)
        ->where('more','LIKE',"%$search%")
        ->paginate(8);
        $sotrang = $yeucaus->lastPage();
        $trang = $yeucaus->currentPage();
        if($request->ajax())
        {
            return [
                'data' => view('admin.yeucauhuydon_data', ['yeucaus' => $yeucaus])->render(),
                'paginate' => view('admin.yeucauhuydon_trang', ['sotrang' => $sotrang, 'trang' => $trang])->render(),
            ];
        }
        return view('admin.yeucauhuydon',[
            'yeucaus'=>$yeucaus,
            'title'=>"Yêu cầu hủy đơn hàng",
            'sotrang'=>$sotrang,
            'trang'=>$trang,
        ]);
    }
    public function duyetyeucau(Request $request)
    {
        $donofwho = DB::table('orders')->where('order_id', $request->order_id)->first();
        DB::table('orders')->where('order_id', $request->order_id)->update([
            'status'=>-1
        ]);
        DB::table('messages')->where('more',$request->order_id)->delete();
        $tt = "Yêu cầu hủy đơn hàng: ".$request->order_id." đã được chấp nhận";
        $current_time = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $formatted_time = $current_time->format("Y-m-d H:i:s");
        $newmess = new Message();
        $newmess->user_id = $donofwho->user_id;
        $newmess->content = $tt;
        $newmess->sender = Auth::user()->name;
        $newmess->created_at = $formatted_time;
        $newmess->save();

        try {
            event(new ThongBaoClientEvent($tt, $donofwho));
        } catch (\Exception $e) {
        }

        return 1;
        
    }
    public function tuchoiyeucau(Request $request)
    {
        $donofwho = DB::table('orders')->where('order_id', $request->order_id)->first();
        DB::table('messages')->where('more',$request->order_id)->delete();
        $tt = "Yêu cầu hủy đơn hàng: ".$request->order_id." không thành công!";
        $current_time = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $formatted_time = $current_time->format("Y-m-d H:i:s");
        $newmess = new Message();
        $newmess->user_id = $donofwho->user_id;
        $newmess->content = $tt;
        $newmess->sender = Auth::user()->name;
        $newmess->created_at = $formatted_time;
        $newmess->save();

        try {
            event(new ThongBaoClientEvent($tt, $donofwho));
        } catch (\Exception $e) {
        }

        return 1;
        
    }
    public function huydonhang(Request $request)
    {
        $message = Auth::user()->name." đã hủy đơn hàng: ".$request->order_id." của bạn!";
        $this->cancelOrder($request->order_id, $message);
        return 1;
    }
    private function cancelOrder($order_id, $message)
    {
        $donofwho = DB::table('orders')->where('order_id', $order_id)->first();
        DB::table('orders')->where('order_id', $order_id)->update([
            'status'=>-1
        ]);
        DB::table('messages')->where('more',$order_id)->delete();
        $current_time = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $formatted_time = $current_time->format("Y-m-d H:i:s");
        $newmess = new Message();
        $newmess->user_id = $donofwho->user_id;
        $newmess->content = $message;
        $newmess->sender = Auth::user()->name;
        $newmess->created_at = $formatted_time;
        $newmess->save();
        try {
            event(new ThongBaoClientEvent($message, $donofwho));
        } catch (\Exception $e) {
        }
    }
}

