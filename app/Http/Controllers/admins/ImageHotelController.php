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

    public function countImageHotels() {

        $title = "Quản lí ảnh khách sạn" ;

        $countImageHotels = $this->image_hotels->countImageHotels() ;

        return view('admins.images_hotel.manager_image_all_hotel' , compact('title' , 'countImageHotels')) ;
    }

    public function listImagesHotel(Request $request) {

        $hotel_id = $request->hotel_id ;

        $title = "Danh sách ảnh" ;

        $listImages = $this->image_hotels->listImagesHotel($hotel_id) ;

        return view('admins.images_hotel.manager_image_hotel' , compact('title' , 'listImages' , 'hotel_id')) ;
    }

    public function createImageHotel(Request $request) {

        $title = "Thêm ảnh khách sạn" ;

        $hotel_id = $request->hotel_id ;

        return view('admins.images_hotel.create_image_hotel' , compact('title' , 'hotel_id')) ;
    }

    public function storeImageHotel(Request $request) {

        $data['hotel_id'] = $request->hotel_id ;

        if($request->hasFile('image_hotel')) {
            foreach($request->file('image_hotel') as $image) {

                $extension = $image->extension() ;

                $uuid = Str::uuid()->toString() ;

                $file_name = $uuid . '-hotel.'. $extension ;

                $image->move(public_path('images_hotel') , $file_name) ;

                $data['image_hotel'] = 'images_hotel/' . $file_name ;

                ImageHotel::query()->create($data);

            }
        }

        return redirect()->route('manager-images-hotel' , ['hotel_id' => $request->hotel_id]) ;
    }

    public function deleteImage(Request $request) {

        $image_id = $request->image_id ;

        $image = ImageHotel::find($image_id) ;

        if(file_exists($image->image_hotel)) {
            unlink($image->image_hotel) ;
        }

        $image->delete() ;

        return back() ;
    }
}
