<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class RoomClientController extends Controller
{
    protected $rooms ;
    protected $reservations ;

    public function __construct() {
        $this->rooms = new Room() ;
        $this->reservations = new Reservation() ;
    }

    // Check xem phòng còn trống trong thời gian khách mong muốn không ;

    public function checkRoom(Request $request) {

        $room_id = $request->room_id ;
        
        $check_in_date = $request->check_in_date ;

        $check_out_date = $request->check_out_date ;

        $resultCheckRoom = $this->reservations->checkReservation($room_id , $check_in_date , $check_out_date) ;

        return redirect()->route('room-detail' , ['id' => $room_id])->with(['resultCheckRoom' => $resultCheckRoom , 'check_in_date' => $check_in_date , 'check_out_date' => $check_out_date]) ;
    }
    
    // Đặt phòng ;
    public function bookingRoom(Request $request) {
        
        $user = User::where('email' , session('email'))->first() ;

        $user_id = $user->id ;

        $data = $request->all() ;

        $data['user_id'] = $user_id ;

        $data['status_id'] = 1 ;

        $data['reservation_date'] = date('Y-m-d H:i:s') ;

        Reservation::query()->create($data) ;

        return redirect()->route('history-booking') ;
    }

    // Hủy đặt phòng (Phương thức dùng chung cho cả admin và client) ;
    public function cancelBooking(Request $request) {

        $reservation_id = $request->reservation_id ;

        $reservation = Reservation::where('id' , $reservation_id)->first() ;

        $data['status_id'] = 4 ;

        $reservation->update($data) ;

        return back() ;
    }
}
