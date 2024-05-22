<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\ImageRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageRoomController extends Controller
{
    protected $image_rooms ;

    public function __construct() {
        $this->image_rooms = new ImageRoom() ;
    }

    public function countImageRooms() {

        $title = "Quản lí ảnh phòng" ;

        $countImageRooms = $this->image_rooms->countImageRooms() ;

        return view('admins.images_room.manager_image_all_room' , compact('title' , 'countImageRooms')) ;
    }

    public function listImagesRoom(Request $request) {

        $room_id = $request->room_id ;

        $title = "Danh sách ảnh" ;

        $listImages = $this->image_rooms->listImagesRoom($room_id) ;

        return view('admins.images_room.manager_image_room' , compact('title' , 'listImages' , 'room_id')) ;
    }

    public function createImageRoom(Request $request) {

        $title = "Thêm ảnh phòng" ;

        $room_id = $request->room_id ;

        return view('admins.images_room.create_image_room' , compact('title' , 'room_id')) ;
    }

    public function storeImageRoom(Request $request) {

        $data['room_id'] = $request->room_id ;

        if($request->hasFile('image_room')) {
            
            foreach($request->file('image_room') as $image) {

                $extension = $image->extension() ;

                $uuid = Str::uuid()->toString() ;

                $file_name = $uuid . '-room.'. $extension ;

                $image->move(public_path('images_room') , $file_name) ;

                $data['image_room'] = 'images_room/' . $file_name ;

                ImageRoom::query()->create($data);
            }
        }

        return redirect()->route('manager-images-room' , ['room_id' => $request->room_id]) ;
    }

    public function deleteImage(Request $request) {

        $image_id = $request->image_id ;

        $image = ImageRoom::find($image_id) ;

        if(file_exists($image->image_room)) {
            unlink($image->image_room) ;
        }

        $image->delete() ;

        return back() ;
    }
}
