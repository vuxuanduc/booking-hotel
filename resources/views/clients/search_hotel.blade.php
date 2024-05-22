@extends('clients.master_layout_client') 
@section('pageTitle')
    {{ $title }}
@endsection
@section('css')
    <style>
        .stars {
            color:gold ;
            font-size: 24px;
            cursor: pointer;
        }


        .btn-rating {
            background-color : #86B817 ;
            color : white ;
        }
        .modal-body div{
            margin-top : -20px ;
        }
    
        .text-center span {
            font-size : 35px ;
        }
        
        .title-h6 {
            margin-top : 0 ;    
        }
        .top-views {
            padding : 0 ;
        }
        .top-views li {
            border-bottom : 1px dotted gray ;
            padding: 5px 0 ;
        }
        .top-views li a {
            text-decoration : none ;
            color : black ;
        }
        .top-views li h6 {
            font-size : 13px ;
            margin-left : 5px ;
        }
        .details {
            display : grid ;
            margin-left:15px;
            grid-template-columns: 1.5fr 1fr;
        }
        .details div h5 a {
            color : black ;
            text-decoration : none ;
        }

        .details div h6 a {
            color : black ;
            text-decoration : none ;
            font-size : 14px;
        }

        .main {
            display: grid ;
            grid-template-columns: 1fr 2fr;
            border : 1px dotted gray ;
            margin-top : 20px ;
        }
        .main:nth-child(1) {
            margin-top : 0 ;
        }
        .price {
            text-align : right ;
            font-size : 23px ;
            margin-right : 10px ;
        }
        .fa-location-dot {
            margin-right : 5px ;
        }
        .fa-thumbs-up {
            margin-right : 5px ;
            color : #4790cd ;
        }
        .count-rating {
            font-size : 15px ;
        }
        @media (width < 691px) {
            .main {
                display: grid ;
                grid-template-columns: 1fr;
            }
            .main div {
                margin-top : 10px ;
            }
            .details {
                display: grid ;
                grid-template-columns: 1fr;
            }
            .details div {
                margin-top : 10px ;
            }
            .price {
                text-align : left ;
            }

        }
        .room-type {
            margin-top : 10px ;
        }
        .box-booking {
            position : relative ;
        }
        .btn-booking-room {
            position : absolute;
            bottom : 10px ;
            right : 15px ;
            text-decoration : none ;
            color : white ;
            padding: 3px  5px ;
            background-color : #86B817 ;
        }
        .btn-booking-room:hover {
            color : white ;
        }
    </style>
@endsection
@section('content')
<div class="box-details">
    @include('clients.layouts.sidebar')
    <div style="margin-left:10px;margin-top:5px;">
        @foreach($resultSearch as $keySearch => $valueSearch)
            <div class="main px-2 py-2">
                <div>
                    <img src="{{ asset($valueSearch->image_room) }}" alt="Ảnh phòng" width="100%" height="auto">
                </div>
                <div class="details">
                    <div class="">
                        <h5><a href="{{ route('hotel-detail' , ['id' => $valueSearch->hotel_id]) }}">{{ $valueSearch->name_hotel }}</a></h5>
                        <p style="margin-top:10px;">
                            <i class="fa-solid fa-thumbs-up"></i> <span class="count-rating">{{ $countRatings[$valueSearch->hotel_id] }} Lượt đánh giá</span>
                        </p>
                        <p style="margin-top:10px;font-size:13px;color:#4790cd;"><i class="fa-solid fa-location-dot"></i>{{ $valueSearch->address }}</p>
                        <h6><a href="{{ route('room-detail' , ['id' => $valueSearch->room_id]) }}">{{ $valueSearch->room_name }}</a></h6>
                        <p class="room-type"><span>Loại phòng : </span><span>{{ $valueSearch->room_type_name }}</span></p>
                    </div>
                    <div class="box-booking">
                        <p class="price"><span style="font-weight:500;color:#86B817;">{{ number_format($valueSearch->price) }}</span><span style="font-size:15px;margin-left:3px;">VND/đêm</span></p> <br>
                        <a href="{{ route('room-detail' , ['id' => $valueSearch->room_id]) }}" class="btn-booking-room">Đặt phòng</a>
                    </div>
                </div>
            </div>
        @endforeach
        
        @if(empty($resultSearch)) 
            <h4>Không tìm thấy kết quả nào !</h4>
        @endif 
        
    </div>
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
        function validateSearch() {
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