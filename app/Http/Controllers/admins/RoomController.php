<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\admins\RoomRequest;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    
    public function index()
    {
        $title = "Quản lí phòng" ;

        $listRooms = Room::query()->latest('id')->paginate(10) ;

        return view('admins.rooms.manager_room' , compact('title' , 'listRooms')) ;
    }

    
    public function create()
    {
        $title = "Thêm mới phòng" ;

        $listHotels = Hotel::query()->pluck('name_hotel' , 'id')->all() ;
        
        $listRoomTypes = RoomType::query()->pluck('room_type_name' , 'id')->all() ;

        return view('admins.rooms.create_room' , compact('title' , 'listHotels' , 'listRoomTypes')) ;
    }

    
    public function store(RoomRequest $request)
    {
        $data = $request->all() ;

        Room::query()->create($data) ;

        return response()->json(['status' => 'success']) ;
    }

    
    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        $title = "Cập nhật phòng" ;

        $room = Room::find($id) ;

        $listHotels = Hotel::query()->pluck('name_hotel' , 'id')->all() ;
        
        $listRoomTypes = RoomType::query()->pluck('room_type_name' , 'id')->all() ;

        return view('admins.rooms.update_room' , compact('title' , 'room' , 'listHotels' , 'listRoomTypes')) ;
    }

    
    public function update(RoomRequest $request, string $id)
    {
        $room = Room::find($id) ;

        $data = $request->all() ;

        $room->update($data) ;

        return response()->json(['status' => 'success']) ;
    }

    
    public function destroy(string $id)
    {
        $room = Room::find($id) ;

        if(!$room->checkImagesRoom()->exists() && !$room->checkReservations()->exists()) {
            $room->delete() ;
        }

        return redirect()->route('rooms.index') ;
    }
}
