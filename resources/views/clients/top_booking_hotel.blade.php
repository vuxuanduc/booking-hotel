@extends('clients.master_layout_client') 
@section('pageTitle')
    {{ $title }}
@endsection
@section('css')

@endsection
@section('content')
<!-- Hiển thị danh sách tất cả các khách sạn phụ thuộc vào biến $_GET phía sau biến action trên thanh trình duyệt -->

<div class="row" style="padding: 10px;margin-top: 20px;">
    <h5>{{ mb_convert_case($title, MB_CASE_UPPER, "UTF-8") }}</h5>
    
    @foreach ($topBookingHotel as $keyHotel => $valueHotel)
        <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2" style="padding: 20px;background-color: #ffffff;">
            <div class="card">
                <img src="{{ asset($valueHotel->image_hotel) }}" class="card-img-top" alt="Lỗi tải ảnh">
                <div class="card-name">
                    <h6 class="card-title my-2"><a style="color:black;text-decoration:none;" href="{{ route('hotel-detail' , ['id' => $valueHotel->id]) }}">{{ $valueHotel->name_hotel }}</a></h6>
                </div>
            </div>
        </div>
    @endforeach
    
</div>
@endsection
@section('script')
    
@endsection