<?php

use App\Http\Controllers\admins\ChartController;
use App\Http\Controllers\admins\DashboardController;
use App\Http\Controllers\admins\HotelController;
use App\Http\Controllers\admins\RatingController;
use App\Http\Controllers\admins\RoomTypeController;
use App\Http\Controllers\admins\UserController;
use App\Http\Controllers\admins\CommentController;
use App\Http\Controllers\admins\ImageHotelController;
use App\Http\Controllers\admins\ImageRoomController;
use App\Http\Controllers\admins\PayController;
use App\Http\Controllers\admins\ReservationController;
use App\Http\Controllers\admins\RoomController;
use App\Http\Controllers\admins\StatusController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RoomClientController;
use App\Http\Controllers\CommentClientController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingClientController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route client

Route::get('/' , [Controller::class , 'homePage'])->name('/') ; // Trang chủ
Route::get('/hotel-detail/{id}' , [Controller::class , 'pageHotelDetail'])->name('hotel-detail') ; // Trang chi tiết khách sạn ;
Route::get('/room-detail/{id}' , [Controller::class , 'pageRoomDetail'])->name('room-detail') ; // Trang chi tiết phòng ;
Route::get('/all-hotel' , [Controller::class , 'allHotel'])->name('all-hotel') ; // Lấy tất cả khách sạn phía người dùng ;
Route::get('/top-view-hotel' , [Controller::class , 'topViewHotel'])->name('top-view-hotel') ; // Lấy top 8 khách sạn có lượt xem nhiều nhất ;
Route::get('/top-booking-hotel' , [Controller::class , 'topBookingHotel'])->name('top-booking-hotel') ; // Lấy top 8 khách sạn có lượt đặt phòng nhiều nhất ;
Route::get('/search-hotel' , [Controller::class , 'searchHotel'])->name('search-hotel') ; // Chức năng tìm kiếm ;
Route::post('/check-room' , [RoomClientController::class , 'checkRoom'])->name('check-room') ; // Kiểm tra xem phòng còn trống trong khoảng thời gian nào đó ;
Route::get('/login' , [LoginController::class , 'pageLogin'])->name('login') ; // Trang đăng nhập ;
Route::post('/login-processing' , [LoginController::class , 'loginProcessing'])->name('login-processing') ; // Chức năng đăng nhập
Route::get('/signup' , [SignupController::class , 'pageSignup'])->name('signup') ; // Trang đăng kí tài khoản ;
Route::post('/signup-processing' , [SignupController::class , 'signupProcessing'])->name('signup-processing') ; // Chức năng đăng kí tài khoản ;
Route::get('/forgot' , [ForgotController::class , 'pageForgot'])->name('forgot') ; // Trang quên mật khẩu ;
Route::post('/forgot-processing' , [ForgotController::class , 'forgotProcessing'])->name('forgot-processing') ; // Chức năng lấy lại mật khẩu ;
//Route::get('/notification' , [ForgotController::class , 'notification'])->name('notification') ; // Trang thông báo đã gửi mật khẩu về mail ;

// Route post-comment chính xác thì phải cần đưa vào danh sách những route cần đăng nhập mới dùng được tuy nhiên đã được check đăng nhập ở phần request rồi nên có thể để ngoài ;
Route::post('/post-comment' , [CommentClientController::class , 'postComment'])->name('post-comment') ; // Chức năng bình luận của người dùng ;

// Các route cần đăng nhập mới dùng được ;
Route::group(['middleware' => 'checkLogin'] , function() {
    Route::get('/logout' , [Controller::class , 'logout'])->name('logout') ; // Chức năng đăng xuất ;
    Route::post('/post-rating' , [RatingClientController::class , 'postRating'])->name('post-rating') ; // Chức năng đánh giá của người dùng ;
    Route::post('/booking-room' , [RoomClientController::class , 'bookingRoom'])->name('booking-room') ; // Đặt phòng ;
    Route::put('/cancel-booking' , [RoomClientController::class , 'cancelBooking'])->name('cancel-booking') ; // Hủy đặt phòng ;
    Route::post('/payment-vnpay' , [PaymentController::class , 'payVnPay'])->name('payment-vnpay') ; // Thanh toán vnpay ;
    Route::get('history-booking' , [Controller::class , 'historyBooking'])->name('history-booking') ; // Lịch sử đặt phòng của mỗi user ;
    Route::get('/profile' , [Controller::class , 'pageProfile'])->name('profile') ; // Trang thông tin tài khoản ;
    Route::put('change-password' , [ProfileController::class , 'changePassword'])->name('change-password') ; // Thay đổi mật khẩu tài khoản ;
    Route::put('change-info' , [ProfileController::class , 'changeInfo'])->name('change-info') ; // Thay đổi thông tin cá nhân ;
}) ;


// Route admin
Route::group(['prefix' => 'admin' , 'middleware' => 'checkAdmin'] , function() {
    Route::get('/dashboard' , [DashboardController::class , 'dashboardController'])->name('dashboard') ; // Trang chủ phần quản trị ;
    Route::resource('/hotels' , HotelController::class)->except('show') ; // CRUD khách sạn ;
    Route::resource('/room-types' , RoomTypeController::class)->except('show') ; // CRUD loại phòng ;
    Route::resource('/rooms' , RoomController::class)->except('show') ; // CRUD phòng ;
    Route::resource('/users' , UserController::class)->except('show') ; // CRUD người dùng ;
    Route::resource('/statuses' , StatusController::class)->except('show') ; // CRUD trạng thái đặt phòng ;

    Route::get('/manager-ratings-all-hotel' , [RatingController::class , 'managerRatingAllHotelController'])->name('manager-ratings-all-hotel') ; // Quản lí đánh giá tất cả các khách sạn ;
    Route::get('/manager-ratings-hotel/{hotel_id}' , [RatingController::class , 'managerRatingHotelController'])->name('manager-ratings-hotel') ; // Quản lí đánh giá của một khách sạn ;
    Route::put('/hidden-rating/{rating_id}' , [RatingController::class , 'hiddenRating'])->name('hidden-rating') ; // Chức năng ẩn đánh giá ;
    Route::put('/show-rating/{rating_id}' , [RatingController::class , 'showRating'])->name('show-rating') ; // Chức năng hiện thị lại đánh giá ;

    Route::get('/manager-comments-all-hotel' , [CommentController::class , 'managerCommentAllHotelController'])->name('manager-comments-all-hotel') ; // Quản lí bình luận tất cả các khách sạn ;
    Route::get('/manager-comments-hotel/{hotel_id}' , [CommentController::class , 'managerCommentHotelController'])->name('manager-comments-hotel') ; // Quản lí bình luận của mỗi khách sạn ;
    Route::put('/hidden-comment/{comment_id}' , [CommentController::class , 'hiddenComment'])->name('hidden-comment') ; // Chức năng ẩn bình luận ;
    Route::put('/show-comment/{comment_id}' , [CommentController::class , 'showComment'])->name('show-comment') ; // Chức năng hiển thị lại bình luận ;

    Route::get('/manager-pays' , [PayController::class , 'listPays'])->name('manager-pays') ; // Quản lí phương thức thanh toán ;
    Route::get('/manager-reservations' , [ReservationController::class , 'listReservations'])->name('manager-reservations') ; // Quản lí danh sách đặt phòng ;
    Route::put('confirm-booking' , [ReservationController::class , 'confirmBooking'])->name('confirm-booking') ; // Xác nhận đơn đặt phòng trong trang admin ;

    Route::get('/manager-images-all-hotel' , [ImageHotelController::class , 'countImageHotels'])->name('manager-images-all-hotel') ; // Quản lí ảnh tất cả các khách sạn ;
    Route::get('/manager-images-hotel/{hotel_id}' , [ImageHotelController::class , 'listImagesHotel'])->name('manager-images-hotel') ; // Quản lí ảnh của một khách sạn ;
    Route::get('/create-image-hotel/{hotel_id}' , [ImageHotelController::class , 'createImageHotel'])->name('create-image-hotel') ; // Trang thêm ảnh cho khách sạn ;
    Route::post('/store-image-hotel' , [ImageHotelController::class , 'storeImageHotel'])->name('store-image-hotel') ; // Chức năng thêm ảnh cho khách sạn ;
    Route::delete('/delete-image-hotel/{image_id}' , [ImageHotelController::class , 'deleteImage'])->name('delete-image-hotel') ; // Chức năng xóa ảnh khách sạn ;

    Route::get('/manager-images-all-room' , [ImageRoomController::class , 'countImageRooms'])->name('manager-images-all-room') ; // Quản lí ảnh tất cả các phòng ;
    Route::get('/manager-images-room/{room_id}' , [ImageRoomController::class , 'listImagesRoom'])->name('manager-images-room') ; // Quản lí ảnh của một phòng ;
    Route::get('/create-image-room/{room_id}' , [ImageRoomController::class , 'createImageRoom'])->name('create-image-room') ; // Trang thêm ảnh cho phòng ;
    Route::post('/store-image-room' , [ImageRoomController::class , 'storeImageRoom'])->name('store-image-room') ; // Chức năng thêm ảnh cho phòng ;
    Route::delete('/delete-image-room/{image_id}' , [ImageRoomController::class , 'deleteImage'])->name('delete-image-room') ; // Chức năng xóa ảnh phòng ;

    Route::get('/chart-revenue' , [ChartController::class , 'chartRevenue'])->name('chart-revenue') ; // Trang thống kê doanh thu bằng biểu đồ ;
    Route::post('/post-chart-revenue' , [ChartController::class , 'resultRevenue'])->name('post-chart-revenue') ; // Chọn mốc thời gian thống kê(ngày , tháng , năm (doanh thu)) ;
    Route::get('/chart-bookings' , [ChartController::class , 'chartBooking'])->name('chart-bookings') ; // Trang thống kê lượt đặt phòng bằng biểu đồ ;
    Route::post('/post-chart-bookings' , [ChartController::class , 'resultBooking'])->name('post-chart-bookings') ; // Chọn mốc thời gian thống kê(ngày , tháng , năm (lượt đặt phòng)) ;
}) ;