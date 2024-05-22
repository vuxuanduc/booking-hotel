<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chart extends Model
{
    use HasFactory;

    // Thống kê doanh thu của mỗi khách sạn theo ngày tháng năm ;

    public function chartRevenue($type , $time) {
        switch($type) {
            case "day" : 
                return Reservation::select('hotels.name_hotel' , DB::raw('sum(reservations.total_amount) as total_revenue'))
                            ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                            ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                            ->whereDate('reservations.reservation_date' , '=' , $time)
                            ->whereIn('reservations.status_id' , [3 , 5])
                            ->groupBy('hotels.name_hotel')
                            ->orderByDesc('total_revenue')
                            ->get() ;
            case "month" :
                return Reservation::select('hotels.name_hotel' , DB::raw('sum(reservations.total_amount) as total_revenue'))
                            ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                            ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                            ->where(DB::raw("DATE_FORMAT(reservations.reservation_date , '%Y-%m')") , $time)
                            ->whereIn('reservations.status_id' , [3 , 5])
                            ->groupBy('hotels.name_hotel')
                            ->orderByDesc('total_revenue')
                            ->get() ;
            case "year" :
                return Reservation::select('hotels.name_hotel' , DB::raw('sum(reservations.total_amount) as total_revenue'))
                            ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                            ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                            ->whereYear('reservations.reservation_date' , $time)
                            ->whereIn('reservations.status_id' , [3 , 5])
                            ->groupBy('hotels.name_hotel')
                            ->orderByDesc('total_revenue')
                            ->get() ;
            default:
                return Reservation::select('hotels.name_hotel' , DB::raw('sum(reservations.total_amount) as total_revenue'))
                            ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                            ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                            ->whereIn('reservations.status_id' , [3 , 5])
                            ->groupBy('hotels.name_hotel')
                            ->orderByDesc('total_revenue')
                            ->get() ;
        }
    }

    // Thống kê tổng số lượt đặt phòng của mối khách sạn theo ngày tháng năm ;

    public function chartBookings($type , $time) {
        switch($type) {
            case "day" : 
                return Reservation::select('hotels.name_hotel' , DB::raw('count(reservations.id) as total_bookings'))
                            ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                            ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                            ->whereDate('reservations.reservation_date' , '=' , $time)
                            ->whereIn('reservations.status_id' , [3 , 5])
                            ->groupBy('hotels.name_hotel')
                            ->orderByDesc('total_bookings')
                            ->get() ;
            case "month" :
                return Reservation::select('hotels.name_hotel' , DB::raw('count(reservations.id) as total_bookings'))
                            ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                            ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                            ->where(DB::raw("DATE_FORMAT(reservations.reservation_date , '%Y-%m')") , $time)
                            ->whereIn('reservations.status_id' , [3 , 5])
                            ->groupBy('hotels.name_hotel')
                            ->orderByDesc('total_bookings')
                            ->get() ;
            case "year" :
                return Reservation::select('hotels.name_hotel' , DB::raw('count(reservations.id) as total_bookings'))
                            ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                            ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                            ->whereYear('reservations.reservation_date' , $time)
                            ->whereIn('reservations.status_id' , [3 , 5])
                            ->groupBy('hotels.name_hotel')
                            ->orderByDesc('total_bookings')
                            ->get() ;
            default:
                return Reservation::select('hotels.name_hotel' , DB::raw('count(reservations.id) as total_bookings'))
                            ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                            ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                            ->whereIn('reservations.status_id' , [3 , 5])
                            ->groupBy('hotels.name_hotel')
                            ->orderByDesc('total_bookings')
                            ->get() ;
        }
    }
}
