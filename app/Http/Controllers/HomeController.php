<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 1)
        {
            return redirect('/admin/sanpham');
        }
        else
        {
            return redirect('/');
        }
    }
}
