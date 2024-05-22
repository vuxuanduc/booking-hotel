<?php

namespace App\Http\Controllers;

use App\Http\Requests\clients\RatingRequest;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RatingClientController extends Controller
{
    public function postRating(RatingRequest $request) {

        $dataRating = $request->all() ;

        $dataRating['date_rating'] = date('Y-m-d') ;

        $dataRating['reservation_id'] = Session::get('reservation_id') ;

        Rating::query()->create($dataRating) ;

        Session::forget('reservation_id') ;

        $dataRating['email'] = Session::get('email') ;

        return response()->json(['status' => 'success' , 'data' => $dataRating]) ;
    }
}
