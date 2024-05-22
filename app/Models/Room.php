<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id' ,
        'room_type_id' ,
        'room_name' ,
        'number_people' ,
        'description' ,
        'price' ,
        'status' ,
    ] ;

    protected $table = "rooms" ;
    
    // Dánh sách ảnh của phòng ;
    public function imagesRoom() {
        return $this->hasMany(ImageRoom::class) ;
    }

    // Danh sách phòng của khách sạn ;
    public function listRoomHotel($id){
        return $this->select('rooms.id', 'rooms.room_name' , 'rooms.number_people', 'rooms.price', 'room_types.room_type_name', DB::raw('(SELECT DISTINCT image_room FROM image_rooms WHERE room_id = rooms.id LIMIT 1) AS image_room'))
        ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
        ->where('rooms.hotel_id', '=', $id)
        ->where('rooms.status', '=', 1)
        ->orderByDesc('rooms.price')
        ->get();
    }

    // Chi tiết phòng ;
    public function roomDetail($id) {
        return $this->select('rooms.id' , 'rooms.hotel_id' , 'rooms.room_name' , 'rooms.price' , 'rooms.description' , 'rooms.number_people' , 'rooms.status' , 'hotels.name_hotel' , 'room_types.room_type_name')
                    ->with('imagesRoom')
                    ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                    ->join('room_types' , 'room_types.id' , '=' , 'rooms.room_type_id')
                    ->where('rooms.id' , '=' , $id)
                    ->first() ;
    }

    // Danh sách phòng cùng khách sạn ;
    public function listRoomHotelExceptId($roomId , $hotelId){
        return $this->select('rooms.id', 'rooms.room_name' , 'rooms.number_people', 'rooms.price', 'room_types.room_type_name', DB::raw('(SELECT DISTINCT image_room FROM image_rooms WHERE room_id = rooms.id LIMIT 1) AS image_room'))
        ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
        ->where('rooms.hotel_id', '=', $hotelId)
        ->where('rooms.status', '=', 1)
        ->whereNotIn('rooms.id' , [$roomId])
        ->orderByDesc('rooms.price')
        ->get();
    }

    // Phần admin ;

    // Lấy tên khách sạn cho phòng ;
    public function hotel() {
        return $this->belongsTo(Hotel::class) ;
    }

    // Lấy tên loại phòng cho phòng ;
    public function roomType() {
        return $this->belongsTo(RoomType::class) ;
    }

    // Kiểm tra ràng buộc với bản ghi nào ở bảng image_rooms không ;
    public function checkImagesRoom() {
        return $this->hasMany(ImageRoom::class) ;
    }

    // Kiểm tra ràng buộc với bảng đặt phòng ;
    public function checkReservations() {
        return $this->hasMany(Reservation::class) ;
    }

    public function reservations() {
        return $this->hasMany(Reservation::class) ;
    }


    // Kiểm tra phòng xem nó còn trống hay không trước khi đặt ;
    // public function checkRoom($room_id, $check_in_date, $check_out_date) {
    //     return DB::table('rooms as r')
    //     ->where('r.id', $room_id)
    //     ->whereNotExists(function ($query) use ($room_id, $check_in_date, $check_out_date) {
    //         $query->select('*') // Thay đổi select từ select(1) thành select('*')
    //             ->from('reservations as res')
    //             ->whereRaw('res.room_id = r.id')
    //             ->where(function ($query) use ($check_in_date, $check_out_date) {
    //                 $query->whereBetween('res.check_in_date', [$check_in_date, $check_out_date])
    //                     ->orWhereBetween('res.check_out_date', [$check_in_date, $check_out_date]);
    //             })
    //             ->where('res.status_id', '<>', 4);
    //     })
    //     ->select('*') // Thay đổi select từ select(1) thành select('*')
    //     ->first();
    // }
    
}
