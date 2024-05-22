<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id' ,
        'room_id' ,
        'status_id' ,
        'reservation_date',
        'check_in_date' ,
        'check_out_date' ,
        'price' ,
        'total_amount' ,
    ] ;

    public function reservations() {
        return $this->select('reservations.id' ,
                    'reservations.reservation_date' , 
                    'reservations.check_in_date' , 
                    'reservations.check_out_date' ,
                    'reservations.price' , 
                    'reservations.total_amount' ,
                    'hotels.name_hotel' ,
                    'rooms.room_name' ,
                    'users.email' , 
                    'statuses.name_status')
                    ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                    ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                    ->join('users' , 'users.id' , '=' , 'reservations.user_id')
                    ->join('statuses' , 'statuses.id' , '=' , 'reservations.status_id')
                    ->orderByDesc('reservations.reservation_date')
                    ->paginate(10) ;
    }

    // Check xem phòng còn trống hay không trong khoảng thời gian người dùng mong muốn ;
    public function checkReservation($room_id, $check_in_date, $check_out_date) {
        return DB::table('reservations as res')
                ->select(DB::raw(1))
                ->where('res.room_id', '=', $room_id)
                ->where(function ($query) use ($check_in_date, $check_out_date) {
                    $query->where(function ($query) use ($check_in_date, $check_out_date) {
                        $query->where('res.check_in_date', '<=', $check_out_date)
                              ->where('res.check_out_date', '>=', $check_in_date);
                    });
                })
                ->where('res.status_id', '<>', '4')
                ->get();
    }
    

    // Lấy tất cả các lần đặt phòng của mỗi user ;

    public function getHistoryBookingHotel($userId) {
        return $this->select('reservations.id',
                             'reservations.reservation_date' , 
                             'reservations.check_in_date' ,
                             'reservations.check_out_date' ,
                             'reservations.total_amount' ,
                             'rooms.room_name' ,
                             'statuses.name_status')
                    ->join('rooms' , 'reservations.room_id' , '=' , 'rooms.id')
                    ->join('statuses' , 'reservations.status_id' , '=' , 'statuses.id')
                    ->where('user_id' , $userId)
                    ->orderByDesc('reservations.reservation_date')
                    ->get() ;
    }

    // Lấy lần đặt phòng mới nhất của một user tại một khách sạn nào đó ;
    public function getLatestReservation($user_id, $hotel_id) {
        return $this->select('reservations.*')
                    ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                    ->join('hotels', 'hotels.id', '=', 'rooms.hotel_id')
                    ->join('users', 'users.id', '=', 'reservations.user_id')
                    ->where('reservations.user_id', $user_id)
                    ->where('rooms.hotel_id', $hotel_id)
                    ->where('reservations.status_id', 5)
                    ->orderByDesc('reservations.created_at')
                    ->first();
    }

    // Lấy danh sách đặt phòng hôm nay và hôm qua có trạng thái là chờ thanh toán ;
    public function listBookingTodayAndYesterday() {
        // Lấy ngày tháng năm hiện tại
        $timeNow = new DateTime();
        $today = $timeNow->format('Y-m-d');
    
        // Lấy ngày tháng năm hôm qua
        $yesterday = $timeNow->modify('-1 day')->format('Y-m-d');
    
        return $this->where('status_id', 2)
                    ->where(function($query) use ($today, $yesterday) {
                        $query->whereDate('reservation_date', $today)
                              ->orWhereDate('reservation_date', $yesterday);
                    })
                    ->get();
    }

    // Lấy danh sách đặt phòng có ngày trả phòng là ngày hôm qua ;
    public function listBookingCheckOutDateYesterday() {
        $timeNow = new DateTime();
        $yesterday = $timeNow->modify('-1 day')->format('Y-m-d');
        return $this->where('status_id' , 3)
                    ->whereDate('check_out_date' , $yesterday)
                    ->get() ;
    }
    
    
}
