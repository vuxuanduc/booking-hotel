<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratings ;

    public function __construct() {
        $this->ratings = new Rating() ;
    }

    public function managerRatingAllHotelController() {

        $title = "Quản lí đánh giá" ;

        $listRatingsAllHotel = $this->ratings->listRatingAdminAllHotel() ;

        return view('admins.ratings.manager_rating_all_hotel' , compact('title' , 'listRatingsAllHotel')) ;
    }

    public function managerRatingHotelController(Request $request) {

        $hotelId = $request->hotel_id ;

        $title = "Danh sách đánh giá theo khách sạn" ;

        $listRatings = $this->ratings->listRatingsAdmin($hotelId) ;

        return view('admins.ratings.manager_rating_hotel' , compact('title' , 'listRatings')) ;
    }

    public function hiddenRating(Request $request) {

        $ratingId = $request->rating_id;
        
        $this->ratings->hiddenRating($ratingId) ;
    
        return back();
    }

    public function showRating(Request $request) {

        $ratingId = $request->rating_id;
        
        $this->ratings->showRating($ratingId) ;
    
        return back();
    }
    
}
