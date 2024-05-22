<?php

namespace App\Http\Controllers;

use App\Http\Requests\clients\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function pageLogin() {
        $title = 'Đăng nhập' ;

        return view('clients.login' , compact('title')) ;
    }

    public function loginProcessing(LoginRequest $request){

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            Session::put('email', $user->email);

            Session::put('user_id', $user->id);

            Session::put('role_id', $user->role_id);

            return response()->json(['status' => 'success']);
        } 
    }
}
