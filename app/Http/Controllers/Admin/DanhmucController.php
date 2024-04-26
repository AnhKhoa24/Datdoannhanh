<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Danhmuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DanhmucController extends Controller
{
    public function index(Request $request)
    {
        $search = "";
        if ($request->search) {
            $search = $request->search;
        }
        $danhmucs = DB::table('danhmucs')->where('tendanhmuc', 'LIKE', "%$search%")->paginate(8);
        return view('admin.danhmuc', [
            'danhmucs' => $danhmucs,
            'title' => 'Danh mục',
            'search' => $search,
        ]);
    }
    public function store(Request $request)
    {

        $danhmuc = new Danhmuc();
        $danhmuc->tendanhmuc = $request->tendanhmuc;
        $danhmuc->save();
        $mamd = $danhmuc->id;
        $data = [
            'ma_danhmuc' => $mamd,
            'tendanhmuc' => $request->tendanhmuc,
            'created_at' => $danhmuc->created_at,
        ];
        return $data;
    }
    public function savechange(Request $request)
    {
        //Try catch sẽ update sau
        $danhmuc = Danhmuc::where('ma_danhmuc', $request->ma_danhmuc)->update([
            'tendanhmuc'=>$request->tendanhmuc,
        ]);
        return 1;
    }

    public function xoadanhmuc(Request $request)
    {
        $check = DB::table('products')->where('ma_danhmuc',$request->ma_danhmuc)->get();
        if(sizeof($check) < 1)
        {
            DB::table('danhmucs')->where('ma_danhmuc',$request->ma_danhmuc)->delete();
            return 1;
        }
        else
        {
            return 0;
        }
    
    }
}
