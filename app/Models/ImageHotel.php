<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ImageHotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id' , 
        'image_hotel' ,
    ] ;

    // Lấy số lượng ảnh của từng khách sạn và lấy ra tất cả các khách sạn ;
    public function countImageHotels() {
        return $this->select('hotels.id' , 'hotels.name_hotel' , DB::raw('count(*) as total_images'))
                    ->join('hotels' , 'hotels.id' , '=' , 'image_hotels.hotel_id')
                    ->groupBy('hotels.id' , 'hotels.name_hotel')
                    ->orderByDesc('total_images')
                    ->paginate(10) ;
    }

    // Lấy danh sách ảnh theo khách sạn ;
    public function listImagesHotel($hotel_id) {
        return $this->select('image_hotels.id' , 'image_hotels.image_hotel')
                    ->where('hotel_id' , $hotel_id)
                    ->get() ;
    }

}
