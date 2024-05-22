<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\Pay;
use Illuminate\Http\Request;

class PayController extends Controller
{
    protected $pays ;

    public function __construct() {
        $this->pays = new Pay() ;
    }

    public function listPays() {

        $title = "Danh sách thanh toán" ;

        $listPays = $this->pays->listPays() ;

        return view('admins.pays.manager_pay' , compact('title' , 'listPays')) ;
    }
}
