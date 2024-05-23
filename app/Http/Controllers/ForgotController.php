<?php

namespace App\Http\Controllers;

use App\Http\Requests\clients\ForgotRequest;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotController extends Controller
{
    // Trang quên mật khẩu ;
    public function pageForgot() {

        $title = 'Quên mật khẩu' ;

        return view('clients.forgot' , compact('title')) ;
    }

    // Xử lí quên mật khẩu ;
    public function forgotProcessing(ForgotRequest $request) {
        // Sau khi check ở ForgotRequest thì sẽ chuyển dữ liệu sang phương thức này ;
        $email = $request->email ;

        $user = User::where('email' , $email)->first() ;
        // Tạo một mật khẩu mới ;
        $newPassword = rand(100000 , 999999) ;

        $data['password'] = $newPassword ;
        // Thay đổi mật khẩu cho người dùng ;
        $user->update($data) ;
        // Tiến hành gửi mail chứa mật khẩu mới về cho người dùng ;
        Mail::to($email)->send(new ForgotPassword($newPassword , $email)) ;

        return response()->json(['status' => 'success']) ;
    }

    // Phương thức này không dùng đến ;
    // public function notification() {

    //     $title = "Thông báo" ;

    //     return view('clients.notification' , compact('title')) ;
    // }

}
