<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 1)
        {
            return redirect('admin');
        }
        else
        {
            return redirect('/');
        }
    }
    public function check()
    {
        if(Auth::user())
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function getTinh(Request $request)
    {
        $search ="";
        if($request->search)
        {
            $search = $request->search;
        }
        $tinhs = DB::table('provinces') ->select('code', 'full_name')->where('full_name','LIKE',"%$search%")->get();

        return json_encode($tinhs);
    }
    public function getQH(Request $request)
    {
        $search ="";
        if($request->search)
        {
            $search = $request->search;
        }
        $qhs = DB::table('districts')->where('province_code',$request->ma_tinh)
        ->where('full_name','LIKE',"%$search%")->get();

        return json_encode($qhs);
    }
    public function getPX(Request $request)
    {
        if($request->pxval)
        {
            $takemt = DB::table('wards')->select('districts.*')->join('districts','wards.district_code','districts.code')->where('wards.code',$request->pxval)->first();
            return json_encode($takemt);
        }

        $search ="";
        if($request->search)
        {
            $search = $request->search;
        }
        if($request->ma_qh == -1)
        {
            $px = DB::table('wards')->select('wards.*')->join('districts','wards.district_code','districts.code')
            ->where('districts.province_code',$request->ma_tinh)->where('wards.full_name','LIKE',"%$search%")->get();
            return json_encode($px);
        }
        $qhs = DB::table('wards')->where('district_code',$request->ma_qh)
        ->where('full_name','LIKE',"%$search%")->get();

        return json_encode($qhs);
    }
    public function xoatinnhan(Request $request)
    {
        if($request->user_id)
        {
            DB::table('messages')->where('user_id',$request->user_id)->delete();
            return 1;
        }
        $mes = Message::find($request->id);
        $mes->delete();
        return 1;
    }
    public function loadtinnhan(Request $request)
    {

        Log::debug($request->user_id);
        $mess = DB::table('messages')
        ->where('user_id',$request->user_id)
        ->orderByDesc('created_at')
        ->get();
        $sl = count($mess);
        if($request->ajax())
        {
            return [
                'data' => view('mini_mes', ['tinnhans' => $mess, 'sl'=>$sl])->render(),
            ];
        }
        return 1;
    }

}
