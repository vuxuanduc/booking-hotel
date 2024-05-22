@extends('clients.master_layout_client')
@section('pageTitle')
    {{ $title }}
@endsection
@section('content')
<div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/banner 1.jpg') }}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/banner 2.jpg') }}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/banner 3.jpg') }}" class="d-block w-100" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    <form action="{{ route('search-hotel') }}" method="get" onsubmit="return validateSearchHome();">
        @csrf
        <div class="row row-responsive">
            <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2">
                <div class="card">
                    <label for="" class="search-label">ĐIỂM ĐẾN</label>
                    <input type="text" id="nameHotelSearch" name="name_hotel" placeholder="Tên khách sạn" class="form-control my-1">
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2">
                <div class="card">
                    <label for="" class="search-label">NGÀY NHẬN PHÒNG</label>
                    <input id="myID" name="check_in_date" placeholder="Ngày đến..." class="form-control my-1 checkInSearch">
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2">
                <div class="card">
                    <label for="" class="search-label">NGÀY TRẢ PHÒNG</label>
                    <input name="check_out_date" placeholder="Ngày đi..." id="myID" class="form-control my-1 checkOutSearch">
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2">
                <div class="card">
                    <label for="" class="search-label">SỐ NGƯỜI</label>
                    <input type="number" name="number_people" id="quantitySearch" min="0" step="1" placeholder="Số người" class="form-control my-1">
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2">
                <div class="card">
                    <label for="" class="search-label transparent">Tìm</label>
                    <input type="submit" value="Tìm phòng" class="form-control my-1 btn-search-room">
                </div>
            </div>
        </div>
    </form>
</div>



<div class="row" style="padding: 10px;margin-top: 20px;">
    <div class="col-md-4 col-sm-6 col-12 my-2" style="padding: 20px;background-color: #ffffff;">
        <div class="card">
            <img src="{{ asset('images/Anh1.jpg') }}" class="card-img-top" alt="Ảnh khách sạn">
            <div class="card-name">
                <h6 class="card-title my-2">ĐIỂM ĐẾN HẤP DẪN</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12 my-2" style="padding: 20px;background-color: #ffffff;">
        <div class="card">
            <img src="{{ asset('images/Anh2.jpg') }}" class="card-img-top" alt="Ảnh khách sạn">
            <div class="card-name">
                <h6 class="card-title my-2">DỊCH VỤ CAO CẤP</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12 my-2" style="padding: 20px;background-color: #ffffff;">
        <div class="card">
            <img src="{{ asset('images/Anh3.jpg') }}" class="card-img-top" alt="Ảnh khách sạn">
            <div class="card-name">
                <h6 class="card-title my-2">KHU NGHỈ DƯỠNG SIÊU SANG</h6>
            </div>
        </div>
    </div>
</div>



<div class="row" style="padding: 10px;margin-top: 20px;">
    <h5>TOP ĐIỂM ĐẾN</h5>

    @foreach ($topBookings as $keyBooking => $valueBooking)
    <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2" style="padding: 20px;background-color: #ffffff;">
        <div class="card">
            <img src="{{ asset($valueBooking->image_hotel) }}" class="card-img-top" alt="Ảnh khách sạn">
            <div class="card-name">
                <a href="{{ route('hotel-detail' , ['id' => $valueBooking->id]) }}" style="text-decoration: none;color:black;"><h6 class="card-title my-2">{{ $valueBooking->name_hotel }}</h6></a>
                <!-- <span style="font-size: 13px;">Có công viên nước, từ 1.980k/đêm</span> -->
            </div>
        </div>
    </div>
@endforeach
    
    
</div>

<div class="row" style="padding: 10px;margin-top: 20px;">
    <h5>TOP LƯỢT XEM</h5>
    @foreach ($topViewHotel as $keyViewHotel => $valueViewHotel)
        <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2" style="padding: 20px;background-color: #ffffff;">
            <div class="card">
                <img src="{{ asset($valueViewHotel->image_hotel) }}" class="card-img-top" alt="Ảnh khách sạn">
                <div class="card-name">
                    <a href="{{ route('hotel-detail' , ['id' => $valueViewHotel->id]) }}" style="text-decoration: none;color:black;"><h6 class="card-title my-2">{{ $valueViewHotel->name_hotel }}</h6></a>
                    <!-- <span style="font-size: 13px;">Có công viên nước, từ 1.980k/đêm</span> -->
                </div>
            </div>
        </div>
    @endforeach
</div>
<a class="modalSearch" id="modalSearch" hidden data-bs-toggle="modal" data-bs-target="#modalValidateSearch">Viết đánh giá</a>
<div class="modal fade" id="modalValidateSearch" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo !</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Vui lòng nhập đầy đủ thông tin tìm kiếm !
            </div>
            <div class="modal-footer">
                <button type="button" style="background-color: #86B817;color:white;" class="btn" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        function validateSearchHome() {
            const nameHotelSearch = document.getElementById('nameHotelSearch') ;
            const checkInSearch = document.querySelector('.checkInSearch') ;
            const checkOutSearch = document.querySelector('.checkOutSearch') ;
            const quantitySearch = document.getElementById('quantitySearch') ;
            const btnModelSearch = document.querySelector('#modalSearch');
            let check = true ;
            if(nameHotelSearch.value.trim() == "" || checkInSearch.value.trim() == "" || checkOutSearch.value.trim() == "" || quantitySearch.value.trim() == "") {
                btnModelSearch.click() ;
                check = false ;
            }
            return check ;
        }
    </script>
@endsection