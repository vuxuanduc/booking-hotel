<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardController(){
        $title = "Trang chủ quản lí" ;
        return view('admins.dashboard' , compact('title')) ;
    }
}
