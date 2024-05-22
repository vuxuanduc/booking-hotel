@extends('clients.master_layout_client') 

@section('pageTitle')
    {{ $title }}
@endsection

@section('css')
<style>
    table {
        width : 100% ;
        margin-top : 15px ;
        border-collapse:collapse ;
        border : 1px dotted gray ;
    }
    table thead {
        height : 45px ;
        background-color : #e4e4e4;
    }
    table thead tr th{
        padding-left : 10px ;
    }
    table tbody tr {
        height : 100px ;
        border : 1px dotted gray ;
    }
    table tbody tr td{
        border : 1px dotted gray ;
        text-align: center ;
    }
    .star {
        font-size: 24px;
        cursor: pointer;
    }

    .star:hover,
    .star.active {
        color: gold;
    }

    .stars {
        font-size: 24px;
        cursor: pointer;
    }

    .star-rating {
        font-size: 18px;
        color : gold ;
    }

    .stars.actives {
        color: gold;
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
    .content-item-ratings , .content-item-comments {
        height : 180px ;
        overflow: hidden ;
    }
    .show-more-ratings {
        display: flex ;
        justify-content: space-between ;
    }
    .show-more-ratings a , .show-more-comments a{
        text-decoration: none ;
        cursor: pointer;
    }
    
</style>
@endsection

@section('content')
<div class="box-details">
    @include('clients.layouts.sidebar')
    @if($hotelDetail)
        @if ($hotelDetail->status == 2)
            <div>
                <h2 class="text-center">Khách sạn tạm dừng hoạt động trên website của chúng tôi</h2>
            </div>
        @else
            <div style="margin-left:10px;">
                <h5>{{ strtoupper($hotelDetail->name_hotel) }}</h5>
                <p style="font-size:12px;"><i style="margin-right:6px;color:#128ce3;" class="fa-solid fa-location-dot"></i>{{ $hotelDetail->address }}</p>
                <div id="carouselExampleFade" class="carousel slide carousel-fade">
                    <div class="carousel-inner">
                        @foreach ($hotelDetail->images as $image)
                            <div class="carousel-item active">
                                <img src="{{ asset($image->image_hotel) }}" class="d-block w-100" alt="Ảnh khách sạn">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <table class="table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">Tên phòng</th>
                            <th class="text-center">Ảnh phòng</th>
                            <th class="text-center">Loại phòng</th>
                            <th class="text-center">Số người</th>
                            <th class="text-center">Giá</th>
                            <th class="text-center">Đặt phòng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listRoomInHotel as $keyRoom => $valueRoom)
                            <tr>
                                <td>
                                    {{ $valueRoom->room_name }} 
                                </td>
                                <td>
                                    <img src="{{ asset($valueRoom->image_room) }}" width="100px" height="auto" alt="">
                                </td>
                                <td>{{ $valueRoom->room_type_name }}</td>
                                <td>{{ $valueRoom->number_people }}</td>
                                <td class="text-danger">{{ number_format($valueRoom->price) .' đ' }}</td>
                                <td>
                                    <a href="{{ route('room-detail' , ['id' => $valueRoom->id]) }}" style="background-color:#86B817;padding:3px 5px;border-radius:3px;color:white;text-decoration:none;">Xem phòng</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="rating my-4">
                    <h5>ĐÁNH GIÁ CỦA KHÁCH HÀNG</h5>
                    <hr>
                    <div class="content">
                        <div class="content-item-ratings">
                            @foreach ($listRatings as $keyRating => $valueRating)
                                
                                <div class="my-1 row">
                                    <div class="col-4">
                                        <span style="font-weight:500;font-size:19px;color:#86B817;">
                                            {{ substr($valueRating->email, 0, 4) . str_repeat('*', strlen($valueRating->email) - 8) . substr($valueRating->email, -4) }}
                                        </span> <br>
                                        <span style="font-size:14px ;">{{ $valueRating->date_rating }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span style="font-weight:400;font-size:16px;">{{ $valueRating->content_rating }}</span> <br>
                                    </div>
                                    <div class="col-2">
                                        @for ($i = 0; $i < $valueRating->rating; $i++)
                                            <span class="star-rating"><i class="fa-solid fa-star"></i></span>
                                        @endfor
                                    </div>
                                </div>

                            @endforeach
                        </div>
                        <div class="show-more-ratings mt-2">
                            @if(Session::has('email') && $checkRating == true)
                                <a class="btn btn-rating" data-bs-toggle="modal" data-bs-target="#exampleModal">Viết đánh giá</a>
                            @endif
                            <a class="btn-show-more-ratings" style="color: #128ce3;">Xem thêm đánh giá</a>
                            <a class="btn-hidden-ratings" style="color: #128ce3;display: none;">Ẩn bớt đánh giá</a>
                        </div>
                    </div>
                </div>
                
                <div class="rating my-4">
                    <h5>BÌNH LUẬN CỦA NGƯỜI DÙNG</h5>
                    <hr>
                    <div class="content">
                        <div class="content-item-comments">
                            @foreach ($listComments as $keyComment => $valueComment)
                                <div class="my-2 row">
                                    <div class="col-4">
                                        <span style="font-weight:500;font-size:19px;color:#86B817;">
                                            {{ substr($valueComment->email, 0, 4) . str_repeat('*', strlen($valueComment->email) - 8) . substr($valueComment->email, -4) }}
                                        </span> <br>
                                        <span style="font-size:14px ;">{{ $valueComment->date_comment }}</span>
                                    </div>
                                    <div class="col-8 mt-1">
                                        <span style="font-weight:400;font-size:16px;">{{ $valueComment->content_comment }}</span> <br>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="show-more-comments mt-3">
                            <a class="btn-show-more-comments" style="color: #128ce3;">Xem thêm bình luận</a>
                            <a class="btn-hidden-comments" style="color: #128ce3;display: none;">Ẩn bớt bình luận</a>
                        </div>
                        <form action="{{ route('post-comment') }}" method="post" class="mt-3" id="form-add-comment">
                            @csrf
                            <input type="hidden" name="email" id="email_comment" value="{{ session('email') }}">
                            <input type="hidden" name="hotel_id" value="{{ $hotelDetail->id }}">
                            <div class="form-group">
                                <label for="" style="font-size: 18px;color:#000000;">Bình luận : <span style="color:red;" class="content_comment_error error"></span></label>
                                <textarea placeholder="Viết bình luận..." name="content_comment" {{ old('content_comment') }} id="" class="form-control mt-1"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn mt-2" style="background-color: #86B817;color:white;">Viết bình luận</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Modal đánh giá ; -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('post-rating') }}" method="post" id="form-add-rating">
                                @csrf
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Đánh giá khách sạn</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center">
                                        <span class="star" data-rating="1">&#9734;</span>
                                        <span class="star" data-rating="2">&#9734;</span>
                                        <span class="star" data-rating="3">&#9734;</span>
                                        <span class="star" data-rating="4">&#9734;</span>
                                        <span class="star" data-rating="5">&#9734;</span>
                                    </p>
                                        <input type="hidden" name="rating" id="input">
                                        {{-- <input type="text" name="reservation_id" value="{{ $reservation_id }}"> --}}
                                    <div>
                                        <label class="my-1" for="" style="display: flex;justify-content: space-between;"><span id="content_rating_error" class="rating-error" style="color : red ;"></span><span id="rating_error" class="rating-error" style="color:red;"></span></label>
                                        <textarea name="content_rating" id="content" placeholder="Viết đánh giá..." class="form-control"></textarea> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn" style="background-color: #86B817;color : white ;">Gửi đánh giá</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <a class="btn btn-rating modalSearch" id="modalSearch" hidden data-bs-toggle="modal" data-bs-target="#modalValidateSearch">Viết đánh giá</a>
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
            </div>
        @endif
    @else
        <div>
            <h2 class="text-center">Không tìm thấy khách sạn!</h2>
        </div>
    @endif
</div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/ajax_form_comment.js') }}"></script>
    <script src="{{ asset('js/ajax_form_rating.js') }}"></script>

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

        const stars = document.querySelectorAll(".star");
        const input = document.querySelector('#input') ;

        stars.forEach((star) => {
        star.addEventListener("click", (e) => {
            const clickedStar = e.target;
            const rating = clickedStar.getAttribute("data-rating");
            input.value = rating ;

            stars.forEach((s) => {
            s.classList.remove("active");
            });

            for (let i = 0; i < rating; i++) {
            stars[i].classList.add("active");
            }
        });
        });
    </script>
    
@endsection