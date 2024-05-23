<?php

namespace App\Http\Controllers;

use App\Http\Requests\clients\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    // Trang đăng kí ;
    public function pageSignup() {
        $title = 'Đăng kí' ;

        return view('clients.signup' , compact('title')) ;
    }

    // Xử lí đăng kí ;
    public function signupProcessing(SignupRequest $request) {

        $data = $request->except('confirm_password') ;

        $data['role_id'] = 2 ;

        User::query()->create($data) ;

        return response()->json(['status' => 'success']) ;
    }
}
