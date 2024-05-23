<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Hotel;
use App\Models\Pay;
use App\Models\Rating;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $hotels ;
    protected $rooms ;
    protected $comments ;
    protected $ratings ;
    protected $reservations ;

    public function __construct() {
        $this->hotels = new Hotel() ;
        $this->rooms = new Room() ;
        $this->comments = new Comment() ;
        $this->ratings = new Rating() ;
        $this->reservations = new Reservation() ;

        $timeNow = new DateTime() ;

        // Lấy danh sách đặt phòng hôm nay và hôm qua ;
        $listBookingTodayAndYesterday = $this->reservations->listBookingTodayAndYesterday() ;

        foreach($listBookingTodayAndYesterday as $booking) {

            $reservationDate = new DateTime($booking->reservation_date) ;

            $interval = $timeNow->diff($reservationDate);

            // Chuyển đổi chênh lệch thời gian sang phút
            $minutes = $interval->days * 24 * 60; // Chuyển đổi số ngày thành phút
            $minutes += $interval->h * 60; // Chuyển đổi số giờ thành phút
            $minutes += $interval->i; // Thêm số phút

            // Kiểm tra nếu đơn đặt phòng được xác nhận sau 30 phút khách hàng chưa thanh toán thì sẽ chuyển sang trạng thái hủy phòng ;
            
            if($minutes > 30) {

                $updateReservation['status_id'] = 4 ;

                $booking->update($updateReservation) ;

            }

        }

        // Lấy danh sách đặt phòng có ngày trả phòng là ngày hôm qua và có trạng thái là đã thanh toán ;
        $listBookingCheckOutDateYesterday = $this->reservations->listBookingCheckOutDateYesterday() ;

        foreach($listBookingCheckOutDateYesterday as $booking) {
            // Cập nhật trạng thái là đã hoàn thành ;
            $updateReservation['status_id'] = 5 ;
            $booking->update($updateReservation) ;
        }

    }

    // View trang chủ ;
    public function homePage() {
        $title = "Trang chủ" ;

        $topViewHotel = $this->hotels->topViewHotel() ;

        $topBookings = $this->hotels->topBookings() ;

        return view('clients.home' , compact('title' , 'topViewHotel' , 'topBookings')) ;
    }

    // Trang tất cả khách sạn ;
    public function allHotel() {

        $title = "Tất cả khách sạn" ;

        $allHotel = $this->hotels->getAllHotel() ;

        return view('clients.all_hotel' , compact('title' , 'allHotel')) ;
    }

    // Trang top khách sạn có lượt xem nhiều nhất ;
    public function topViewHotel() {

        $title = "Lượt xem nhiều nhất" ;

        $topViewHotel = $this->hotels->topViewHotel() ;

        return view('clients.top_view_hotel' , compact('title' , 'topViewHotel')) ;
    }

    // Trang top khách sạn có lượt đặt phòng nhiều nhất ;
    public function topBookingHotel() {

        $title = "Lượt đặt phòng nhiều nhất" ;

        $topBookingHotel = $this->hotels->topBookings() ;

        return view('clients.top_booking_hotel' , compact('title' , 'topBookingHotel')) ;
    }

    // Trang trả về kết quả tìm kiếm khách sạn ;
    public function searchHotel(Request $request) {

        $title = "Tìm kiếm phòng khách sạn" ;

        $topViewHotel = $this->hotels->topViewHotel() ;

        $topBookings = $this->hotels->topBookings() ;

        $nameHotel = $request->name_hotel ;
        $check_in_date = $request->check_in_date ;
        $check_out_date = $request->check_out_date ;
        $numberPeople = $request->number_people ;

        // Khởi tạo mảng số lượt đánh giá ;

        $countRatings = [] ;

        if(!$nameHotel || !$check_in_date || !$check_out_date || !$numberPeople) {
            $resultSearch = [] ;
        }else {
            $resultSearch = $this->hotels->searchHotel($nameHotel , $check_in_date , $check_out_date , $numberPeople) ;

            foreach($resultSearch as $value) {
                $countRatings[$value->hotel_id] = $this->ratings->countRatings($value->hotel_id)->total_ratings ;
            }
        }

        return view('clients.search_hotel' , compact('title' , 'resultSearch' , 'topViewHotel' , 'topBookings' , 'countRatings')) ;

    }

    // Trang chi tiết khách sạn ;
    public function pageHotelDetail(Request $request) {
        // Lấy id hotel từ url ;
        $hotel_id = $request->id ;

        // Tăng lên một lượt xem khách sạn khi người dùng click vào xem chi tiết khách sạn ;
        $hotel = Hotel::find($hotel_id) ;
        $data['number_views'] = $hotel->number_views + 1 ;
        $hotel->update($data) ;

        $title = "Chi tiết khách sạn" ;
        // Danh sách khách sạn có lượt xem nhiều nhất ;
        $topViewHotel = $this->hotels->topViewHotel() ;
        // Top khách sạn có lượt đặt phòng nhiều nhất ;
        $topBookings = $this->hotels->topBookings() ;
        // Lấy tất cả các phòng của khách sạn ;
        $listRoomInHotel = $this->rooms->listRoomHotel($hotel_id) ;
        // Thông tin chi tiết của khách sạn ;
        $hotelDetail = $this->hotels->hotelDetail($hotel_id) ;
        // Danh sách đánh giá khách sạn ;
        $listRatings = $this->ratings->listRatings($hotel_id) ;
        // Danh sách bình luận ;
        $listComments = $this->comments->listComments($hotel_id) ;

        // Kiểm tra xem lần đặt phòng gần nhất(có thể chưa đặt) của người dùng thuộc khách sạn này đã tiến hành đánh giá khách sạn hay chưa ;
        $checkRating = false ;

        $reservation_id = "" ;

        if(Session::has('email')) {

            // Lấy id người dùng được lưu trong session sau khi đăng nhập thành công ;
            $user_id = Session::get('user_id') ;

            // Lấy lần đặt phòng gần nhất của người dùng ;
            $latestReservation = $this->reservations->getLatestReservation($user_id , $hotel_id) ;

            // Check xem người dùng đã đánh giá khách sạn theo đơn đặt phòng phía trên chưa ;

            if($latestReservation) {
                $rating = Rating::where('reservation_id' , $latestReservation->id)->first() ;
                if(!$rating) {
                    $checkRating = true ;
                    // Tạo session để chuẩn bị làm dữ liệu cho chức năng đánh giá ;
                    Session::put('reservation_id' , $latestReservation->id) ;
                }
            }
        }

        return view('clients.hotel_detail' , compact('title' , 'listRoomInHotel' , 'topViewHotel' , 'topBookings' , 'hotelDetail' , 'listComments' , 'listRatings' , 'checkRating' , 'reservation_id')) ;
    }

    // Trang chi tiết phòng ;
    public function pageRoomDetail(Request $request) {

        $room_id = $request->id ;

        $title = "Chi tiết phòng" ;

        $roomDetail = $this->rooms->roomDetail($room_id) ;

        $resultCheckRoom = 1 ;

        if (session()->has('resultCheckRoom') && session('resultCheckRoom')->isEmpty()) {
            $resultCheckRoom = [];
        }
        // Lấy danh sách phòng cùng thuộc khách sạn trừ phòng đang xem ;
        $listRoomHotelExceptId = $this->rooms->listRoomHotelExceptId($room_id , $roomDetail->hotel_id) ;

        return view('clients.room_detail' , compact('title' , 'roomDetail' , 'listRoomHotelExceptId' , 'resultCheckRoom')) ;
    }

    // Trang thông tin người dùng ;
    public function pageProfile() {
        
        $title = "Thông tin tài khoản" ;

        $user = User::where('email' , session('email'))->first() ;

        return view('clients.profile' , compact('title' , 'user')) ;
    }

    // Trang lịch sử đặt phòng ;
    public function historyBooking(Request $request) {

        // Kiểm tra thanh toán ;
        if($request->vnp_TxnRef 
            && $request->vnp_TransactionStatus 
            && $request->vnp_TransactionStatus == '00' 
            && Session::has('$vnp_TxnRef') 
            && Session::get('$vnp_TxnRef') == $request->vnp_TxnRef) {

            $reservation = Reservation::where('id' , Session::get('reservation_id'))->first() ;
            $dataReservation['status_id'] = 3 ;
            // Nếu thanh toán thành công chuyển trạng thái đơn đặt phòng sang đã thanh toán ;
            $reservation->update($dataReservation) ;
            
            // Khởi tạo data để insert vào bảng thanh toán ;
            $dataPay = [
                'reservation_id' => Session::get('reservation_id') ,
                'pay_info' => 'ATM VnPay' 
            ] ;

            Pay::query()->create($dataPay) ;

            Session::forget('reservation_id') ;
            Session::forget('$vnp_TxnRef') ;

        }else {
            Session::forget('reservation_id') ;
            Session::forget('$vnp_TxnRef') ;
        }

        $title = "Lịch sử đặt phòng" ;

        $user = User::where('email' , session('email'))->first() ;

        $user_id = $user->id ;
        // Lấy danh sách đặt phòng của người dùng ;
        $historyBooking = $this->reservations->getHistoryBookingHotel($user_id) ;

        return view('clients.history_booking' , compact('title' , 'historyBooking')) ;
    }

    // Chức nănh đăng xuất ;
    public function logout() {

        Auth::logout(); 

        Session::flush();

        return redirect()->route('/');
    }

}
