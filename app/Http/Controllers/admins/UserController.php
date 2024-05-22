<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\admins\UserAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index()
    {
        $title = "Quản lí người dùng" ;

        $listUsers = User::query()->with('role')->latest('id')->paginate(10) ;

        return view('admins.users.manager_user' , compact('title' , 'listUsers')) ;
    }

    
    public function create()
    {
        $title = "Thêm mới người dùng" ;

        return view('admins.users.create_user' , compact('title')) ;
    }

    
    public function store(UserAdminRequest $request)
    {
        $data = $request->all() ;

        User::query()->create($data) ;
        
        return response()->json(['status' => 'success']) ;
    }

    
    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        $title = "Chỉnh sửa người dùng" ;

        $userId = User::find($id) ;

        return view('admins.users.update_user' , compact('title' , 'userId')) ;
    }

    
    public function update(UserAdminRequest $request, string $id)
    {
        $user = User::find($id) ;

        $data = $request->all() ;

        $user->update($data) ;

        return response()->json(['status' => 'success']) ;
    }

    
    public function destroy(string $id)
    {   
        
        $user = User::find($id) ;

        if(!$user->comments()->exists() && !$user->reservations()->exists()) {
            $user->delete() ;
        }

        return redirect()->route('users.index')->with('success' , 'Xóa người dùng thành công') ;
    }
}
