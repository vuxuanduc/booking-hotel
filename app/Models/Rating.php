<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id' ,
        'rating' ,
        'content_rating' ,
        'date_rating' ,
    ] ;

    protected $table = 'ratings' ;
    
    // Danh sách đánh giá theo id khách sạn ;

    public function listRatings($id) {
        return $this->select('ratings.id' , 'ratings.rating' , 'ratings.content_rating' , 'ratings.status' , 'ratings.date_rating' , 'users.email')
                    ->join('reservations' , 'ratings.reservation_id' , '=' , 'reservations.id')
                    ->join('users' , 'reservations.user_id' , '=' , 'users.id')
                    ->join('rooms' , 'reservations.room_id' , '=' , 'rooms.id')
                    ->join('hotels' , 'rooms.hotel_id' , '=' , 'hotels.id')
                    ->where('hotels.id' , $id)
                    ->where('ratings.status' , 1)
                    ->groupBy('ratings.id' , 'ratings.rating' , 'ratings.content_rating' , 'ratings.status' , 'ratings.date_rating' , 'users.email')
                    ->orderByDesc('ratings.rating')
                    ->get() ;
    }

    // Tính số lượt đánh giá của khách sạn theo id khách sạn hiển thị ra trang search  ;
    public function countRatings($hotel_id) {
        return $this->selectRaw('count(*) as total_ratings')
                    ->join('reservations' , 'reservations.id' , '=' , 'ratings.reservation_id')
                    ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                    ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                    ->where('hotel_id' , $hotel_id)
                    ->first() ;
    }
    
    // Lấy số lượng đánh giá hiển thị ra trang admin ;

    public function listRatingAdminAllHotel() {
        return $this->select('hotels.id' , 'hotels.name_hotel' , DB::raw('count(*) as total_ratings'))
                    ->join('reservations' , 'reservations.id' , '=' , 'ratings.reservation_id')
                    ->join('rooms' , 'rooms.id' , '=' , 'reservations.room_id')
                    ->join('hotels' , 'hotels.id' , '=' , 'rooms.hotel_id')
                    ->groupBy('hotels.id' , 'hotels.name_hotel')
                    ->orderByDesc('total_ratings')
                    ->paginate(10) ;
    }

    
    // Danh sách đánh giá của mỗi khách sạn đổ ra trang quản lí đánh giá của khách sạn ;
    public function listRatingsAdmin($id) {
        return $this->select('ratings.id' , 'ratings.rating' , 'ratings.content_rating' , 'ratings.status' , 'ratings.date_rating' , 'users.email')
                    ->join('reservations' , 'ratings.reservation_id' , '=' , 'reservations.id')
                    ->join('users' , 'reservations.user_id' , '=' , 'users.id')
                    ->join('rooms' , 'reservations.room_id' , '=' , 'rooms.id')
                    ->join('hotels' , 'rooms.hotel_id' , '=' , 'hotels.id')
                    ->where('hotels.id' , $id)
                    ->groupBy('ratings.id' , 'ratings.rating' , 'ratings.content_rating' , 'ratings.status' , 'ratings.date_rating' , 'users.email')
                    ->orderByDesc('ratings.rating')
                    ->paginate(10) ;
    }
    // Ẩn đánh giá ;
    public function hiddenRating($rating_id) {
        return Rating::where('id' , $rating_id)->update(['status' => 2]) ;
    }
    // Hiển thị đánh giá bị ẩn ;
    public function showRating($rating_id) {
        return Rating::where('id' , $rating_id)->update(['status' => 1]) ;
    }
}
