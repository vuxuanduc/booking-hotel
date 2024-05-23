<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\admins\RoomTypeAdminRequest;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    
    public function index()
    {
        $title = "Quản lí loại phòng" ;
        
        $listRoomTypes = RoomType::query()->latest('id')->paginate(10) ;
        
        return view('admins.room_types.manager_room_type' , compact('title' , 'listRoomTypes'))  ;
    }

    
    public function create()
    {
        $title = "Thêm mới loại phòng" ;

        return view('admins.room_types.create_room_type' , compact('title')) ;
    }

    
    public function store(RoomTypeAdminRequest $request)
    {
        $data = $request->all() ;

        RoomType::query()->create($data) ;

        return response()->json(['status' => 'success']) ;
    }

    // Đã xử lí except phương thức này ở route ;
    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        $title = "Cập nhật loại phòng" ;

        $roomType = RoomType::find($id) ;

        return view('admins.room_types.update_room_type' , compact('title' , 'roomType')) ;
    }

    
    public function update(RoomTypeAdminRequest $request, string $id)
    {
        $data = $request->all() ;

        $roomType = RoomType::find($id) ;

        $roomType->update($data) ;

        return response()->json(['status' => 'success']) ;
    }

    
    public function destroy(string $id)
    {
        $roomType = RoomType::find($id) ;

        if(!$roomType->rooms()->exists()) {
            $roomType->delete() ;
        }

        return redirect()->route('room-types.index') ;
    }
}
