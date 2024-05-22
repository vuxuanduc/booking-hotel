<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_hotel' ,
        'address' , 
        'phone' ,
        'email' ,
        'number_views' ,
        'status' ,
    ] ;

    protected $table = 'hotels';

    public function images() {
        return $this->hasMany(ImageHotel::class) ;
    }

    public function rooms() {
        return $this->hasMany(Room::class) ;
    }

    public function comments() {
        return $this->hasMany(Comment::class) ;
    }

    public function getAllHotel() {
        return $this->select('hotels.id', 'hotels.name_hotel' , 'hotels.status' , DB::raw('(SELECT image_hotel FROM image_hotels WHERE hotel_id = hotels.id LIMIT 1) AS image_hotel'))
                    ->where('hotels.status' , '=' , 1)
                    ->orderBy('hotels.number_views', 'desc')
                    ->get();
    }
    
    public function topViewHotel() {
        return $this->select('hotels.id', 'hotels.name_hotel' , 'hotels.status' , DB::raw('(SELECT image_hotel FROM image_hotels WHERE hotel_id = hotels.id LIMIT 1) AS image_hotel'))
                    ->where('hotels.status' , '=' , 1)
                    ->orderBy('hotels.number_views', 'desc')
                    ->take(8)
                    ->get();
    }

    public function topBookings() {
        return $this->select('hotels.id' , 'hotels.name_hotel' , 'hotels.status' , DB::raw('(SELECT image_hotel FROM image_hotels WHERE hotel_id = hotels.id LIMIT 1) AS image_hotel') , DB::raw('COUNT(reservations.id) AS total_bookings'))
                    ->join('rooms' , 'hotels.id' , '=' , 'rooms.hotel_id')
                    ->join('reservations' , 'rooms.id' , '=' , 'reservations.room_id')
                    ->where('hotels.status' , '=' , 1)
                    ->groupBy('hotels.id' , 'hotels.name_hotel' , 'hotels.status' , 'image_hotel')
                    ->orderByDesc('total_bookings')
                    ->take(8)
                    ->get() ;
    }

    public function hotelDetail($id) {
        return $this->select('hotels.id' , 'hotels.name_hotel' , 'hotels.address' , 'hotels.phone' , 'hotels.email' , 'hotels.status')
                    ->with('images')
                    ->where('hotels.id' , '=' , $id)
                    ->first() ;
    }

    // Chức năng tìm kiếm ;
    public function searchHotel($nameHotel , $check_in_date , $check_out_date , $number_people) {
        return DB::table('hotels as h')
                ->select('h.id as hotel_id', 'h.name_hotel', 'h.address', 
                'rm.id as room_id', 'rm.room_name', 'rm.price', DB::raw('(SELECT image_room FROM image_rooms WHERE image_rooms.room_id = rm.id LIMIT 1) AS image_room') ,
                'rt.room_type_name')
                ->join('rooms as rm', 'h.id', '=', 'rm.hotel_id')
                ->join('room_types as rt', 'rt.id', '=', 'rm.room_type_id')
                ->where('rm.number_people', '>=', $number_people)
                ->where('h.name_hotel', 'LIKE', '%' . $nameHotel . '%')
                ->where('h.status', 1)
                ->where('rt.status', 1)
                ->where('rm.status', 1)
                ->whereNotExists(function ($subQuery) use ($check_in_date, $check_out_date) {
                    $subQuery->select(DB::raw(1))
                            ->from('reservations AS res')
                            ->whereColumn('res.room_id', 'rm.id')
                            ->where(function ($query) use ($check_in_date, $check_out_date) {
                                $query->where(function ($query) use ($check_in_date, $check_out_date) {
                                    $query->where('res.check_in_date', '<=', $check_out_date)
                                          ->where('res.check_out_date', '>=', $check_in_date);
                                });
                            })
                            ->where('res.status_id', '<>', '4');
                })
                ->whereRaw("'$check_in_date' >= CURDATE()")
                ->whereRaw("'$check_out_date' >= '$check_in_date'")
                ->get();
    }
}
