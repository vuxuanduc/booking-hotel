<?php

namespace App\Http\Controllers;

use App\Http\Requests\clients\ChangeInfoRequest;
use App\Http\Requests\clients\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Thay đổi mật khẩu trong trang thông tin người dùng ;
    public function changePassword(ChangePasswordRequest $request) {

        $user = User::where('email' , session('email'))->first() ;

        $newPassword = $request->input('new_password') ;

        $data['password'] = $newPassword ;

        $user->update($data) ;

        return response()->json(['status' => 'success']) ;
    }

    // Thay đổi thông tin người dùng trong trang thông tin người dùng ;
    public function changeInfo(ChangeInfoRequest $request) {

        $user = User::where('email' , session('email'))->first() ;

        $data = $request->all() ;

        $user->update($data) ;

        return response()->json(['status' => 'success']) ;
    }
}
