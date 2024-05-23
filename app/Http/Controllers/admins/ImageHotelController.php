<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\ImageHotel;
use Illuminate\Http\Request;
use Illuminate\Support\Str ;

class ImageHotelController extends Controller
{
    protected $image_hotels ;

    public function __construct() {
        $this->image_hotels = new ImageHotel() ;
    }

    // Quản lí số lượng ảnh tất cả các khách sạn ;
    public function countImageHotels() {

        $title = "Quản lí ảnh khách sạn" ;

        $countImageHotels = $this->image_hotels->countImageHotels() ;

        return view('admins.images_hotel.manager_image_all_hotel' , compact('title' , 'countImageHotels')) ;
    }

    // Quản lí ảnh của từng khách sạn ;
    public function listImagesHotel(Request $request) {

        $hotel_id = $request->hotel_id ;

        $title = "Danh sách ảnh" ;

        $listImages = $this->image_hotels->listImagesHotel($hotel_id) ;

        return view('admins.images_hotel.manager_image_hotel' , compact('title' , 'listImages' , 'hotel_id')) ;
    }

    // Giao diện thêm ảnh khách sạn ;
    public function createImageHotel(Request $request) {

        $title = "Thêm ảnh khách sạn" ;

        $hotel_id = $request->hotel_id ;

        return view('admins.images_hotel.create_image_hotel' , compact('title' , 'hotel_id')) ;
    }

    // Xử lí thêm ảnh khách sạn ;
    public function storeImageHotel(Request $request) {

        $data['hotel_id'] = $request->hotel_id ;

        if($request->hasFile('image_hotel')) {
            foreach($request->file('image_hotel') as $image) {

                $extension = $image->extension() ; // Lấy phần mở rộng của ảnh ;

                $uuid = Str::uuid()->toString() ; // Tạo một mã riêng biệt để lưu tên ảnh ;

                $file_name = $uuid . '-hotel.'. $extension ; // Ghép mã với phần mở rộng của tên ảnh ;

                $image->move(public_path('images_hotel') , $file_name) ; // Upload ảnh vào thư mục được chỉ định ;

                $data['image_hotel'] = 'images_hotel/' . $file_name ; // Lưu tên ảnh vào mảng dữ liệu chuẩn bị thêm vào CSDL ;

                ImageHotel::query()->create($data);

            }
        }

        return redirect()->route('manager-images-hotel' , ['hotel_id' => $request->hotel_id]) ;
    }
    
    // Xóa ảnh khách sạn ;
    public function deleteImage(Request $request) {

        $image_id = $request->image_id ;

        // Lấy thông tin ảnh cần xóa ;
        $image = ImageHotel::find($image_id) ;

        // Dựa vào tên ảnh kiểm tra xem ảnh có tồn tại trong thư mục hay không để xóa ảnh ra  khỏi thư mục ;
        if(file_exists($image->image_hotel)) {
            unlink($image->image_hotel) ;
        }

        $image->delete() ;

        return back() ;
    }
}
