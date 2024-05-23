<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    
    public function index()
    {
        $title = "Quản lí khách sạn" ;

        $listHotels = Hotel::query()->latest('id')->paginate(10) ;

        return view('admins.hotels.manager_hotel' , compact('title' , 'listHotels')) ;
    }

    
    public function create()
    {
        $title = "Thêm khách sạn" ;
        
        return view('admins.hotels.create_hotel' , compact('title')) ;
    }

   
    public function store(Request $request)
    {
        $data = $request->all() ;

        Hotel::query()->create($data) ;

        return redirect()->route('hotels.index') ;
    }

    // Đã xử lí except ở route cho phương thức show ;
    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        $title = "Cập nhật khách sạn" ;

        $hotelId = Hotel::find($id) ;

        return view('admins.hotels.update_hotel' , compact('title' , 'hotelId')) ;
    }

    
    public function update(Request $request, string $id)
    {
        $hotel = Hotel::find($id) ;

        $data = $request->all() ;

        $hotel->update($data) ;

        return redirect()->route('hotels.index')->with('success' , 'Cập nhật khách sạn thành công') ;
    }

    
    public function destroy(string $id)
    {
        $hotel = Hotel::find($id) ;

        if(!$hotel->images()->exists() && !$hotel->rooms()->exists() && !$hotel->comments()->exists()) {
            $hotel->delete() ;
        }

        return redirect()->route('hotels.index')->with('success', 'Xóa khách sạn thành công');
    }
}
