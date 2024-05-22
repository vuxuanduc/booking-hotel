<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmBooking;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    protected $reservations ;

    public function __construct() {
        $this->reservations = new Reservation() ;
    }

    public function listReservations() {

        $title = "Quản lí đặt phòng" ;

        $listReservations = $this->reservations->reservations() ;

        return view('admins.reservations.manager_reservation' , compact('title' , 'listReservations')) ;
    }

    public function confirmBooking(Request $request) {

        $reservation_id = $request->reservation_id ;

        $reservation = Reservation::where('id' , $reservation_id)->first() ;

        $data['status_id'] = 2 ;

        $reservation->update($data) ;

        // Lấy thông tin của người đặt phòng để truyền tham số vào mail ;

        $user_id = $reservation->user_id ;

        $user = User::where('id' , $user_id)->first() ;

        $email = $user->email ;

        Mail::to($email)->send(new ConfirmBooking($email)) ;

        return back() ;
    }
}
