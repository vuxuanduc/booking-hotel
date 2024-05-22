<?php

namespace App\Http\Controllers;

use App\Http\Requests\clients\ForgotRequest;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotController extends Controller
{
    public function pageForgot() {

        $title = 'Quên mật khẩu' ;

        return view('clients.forgot' , compact('title')) ;
    }


    public function forgotProcessing(ForgotRequest $request) {
        $email = $request->email ;

        $user = User::where('email' , $email)->first() ;

        $newPassword = rand(100000 , 999999) ;

        $data['password'] = $newPassword ;

        $user->update($data) ;

        Mail::to($email)->send(new ForgotPassword($newPassword , $email)) ;

        return response()->json(['status' => 'success']) ;
    }

    public function notification() {

        $title = "Thông báo" ;

        return view('clients.notification' , compact('title')) ;
    }

}
