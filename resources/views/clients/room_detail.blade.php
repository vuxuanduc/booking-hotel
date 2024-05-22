@extends('clients.master_layout_client')

@section('pageTitle')
    {{ $title }}
@endsection

@section('css')
    <style>
        .room-details {
            display: grid ;
            grid-template-columns : 1fr 1fr 1fr ;
            gap : 10px ; 
        }
        @media (max-width : 1000px) {
            .room-details {
                display: grid ;
                grid-template-columns : 1fr 1fr ;
                gap : 10px ; 
            }
        }
        @media (max-width : 685px) {
            .room-details {
                display: grid ;
                grid-template-columns : 1fr ;
                gap : 10px ; 
            }
        }
        .h6 {
            background-color : #86B817;
        }
        .submit {
            background-color : #86B817;
            color : white ;
        }
        .description {
            display: flex ;
            justify-content: space-between;
            margin-top : 7px ;
        }
        .description p {
            font-weight : 500 ;
        }
        .modal-body {
            text-align : justify ;
        }
        .text-primary {
            cursor: pointer;
        }
        .room-details label {
            font-weight : 500 ;
        }
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
    </style>
@endsection

@section('content')

@if ($roomDetail->status == 2)
    <div class="room-details my-3">
        <h2>Phòng tạm dừng cho thuê</h2>
    </div>
@else
    <div class="room-details my-2">
        <div>
            @if (isset($resultCheckRoom) && !empty($resultCheckRoom))
                <h6 class="py-2 px-1 text-white h6">Kiểm tra phòng</h6>
                @if(session()->has('resultCheckRoom') && !session('resultCheckRoom')->isEmpty())
                    <div class="alert alert-danger">
                        <strong>Phòng không còn trống trong thời gian bạn mong muốn!</strong>
                    </div>
                @endif
                <form action="{{ route('check-room') }}" method="post" class="px-2" onsubmit="return validateCheckRoom();">
                    @csrf    
                    <input type="hidden" name="room_id" value="{{ $roomDetail->id }}">
                    <div class="form-group">
                        <label for="">Ngày nhận phòng</label> <span id="check-in-date-err" style="color:red;margin-left: 5px;"></span>
                        <input placeholder="Ngày đến..." value="{{ session('check_in_date') }}" name="check_in_date" id="myID" class="form-control my-2 check-in-date">
                    </div>
                    <div class="form-group">
                        <label for="">Ngày trả phòng</label> <span id="check-out-date-err" style="color:red;margin-left: 5px;"></span>
                        <input placeholder="Ngày đi..." value="{{ session('check_out_date') }}" name="check_out_date" id="myID" class="form-control my-2 check-out-date">
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Kiểm tra" class="form-control my-3 submit">
                    </div>
                </form>
            @else
                <h6 class="py-2 px-1 text-white h6">Thông tin đặt phòng</h6>
                <form action="{{ route('booking-room') }}" method="post" class="px-2">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $roomDetail->id }}">
                    <div class="form-group">
                        <label for="">Ngày nhận phòng</label> 
                        <input type="date" name="check_in_date" value="{{ session('check_in_date') }}"  class="form-control my-2" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Ngày trả phòng</label> 
                        <input type="date" name="check_out_date" value="{{ session('check_out_date') }}" class="form-control my-2" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Số ngày ở</label>
                        <input type="number" value="{{ \Carbon\Carbon::parse(session('check_in_date'))->diffInDays(\Carbon\Carbon::parse(session('check_out_date'))) }}" class="form-control my-2" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Giá phòng</label> 
                        <input type="number" name="price" value="{{ ceil($roomDetail->price) }}"  class="form-control my-2" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Tổng tiền</label> 
                        <input type="number" name="total_amount" value="{{ ceil((\Carbon\Carbon::parse(session('check_in_date'))->diffInDays(\Carbon\Carbon::parse(session('check_out_date'))) * $roomDetail->price)) }}" class="form-control my-2" readonly>
                    </div>
                    @if(session('email'))
                        <div class="form-group">
                            <input type="submit" value="Đặt phòng" class="form-control my-3 submit" onclick="return confirm('Sau khi đặt phòng 30 phút nếu quý khách không thanh toán đơn sẽ tự động hủy!');">
                        </div>
                    @else
                        <input type="button" class="form-control my-3 submit" data-bs-toggle="modal" data-bs-target="#exampleModal" value="Đặt phòng">
                    @endif
                </form>
            @endif
        </div>

        <!-- Modal thông báo đăng nhập khi chưa đăng nhập mà đã bấm nút đặt phòng ; -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vui lòng đăng nhập trước khi đặt phòng
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <a href="{{ route('login') }}" class="btn text-white" style="background-color: #86B817;">Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h6 class="px-1 py-2 text-white h6">Ảnh phòng</h6>
            <div id="carouselExampleFade" class="carousel slide carousel-fade px-1">
                <div class="carousel-inner">
                    @foreach ($roomDetail->imagesRoom as $image)
                        <div class="carousel-item active">
                            <img src="{{ asset($image->image_room) }}" class="d-block w-100" alt="Lỗi tải ảnh">
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
        </div>
        <div>
            <h6 class="px-1 py-2 text-white h6">Chi tiết phòng</h6>
            <div class="description px-1">
                <p>Tên khách sạn</p>
                <p>{{ $roomDetail->name_hotel }}</p>
            </div>
            <div class="description px-1">
                <p>Tên loại phòng</p>
                <p>{{ $roomDetail->room_type_name }}</p>
            </div>
            <div class="description px-1">
                <p>Tên phòng</p>
                <p>{{ $roomDetail->room_name }}</p>
            </div>
            <div class="description px-1">
                <p>Số người ở</p>
                <p>{{ $roomDetail->number_people }}</p>
            </div>
            <div class="description px-1">
                <p>Giá phòng</p>
                <p>{{ number_format($roomDetail->price) }} đ/1 đêm</p>
            </div>
            <div class="description px-1">
                <p class="text-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Xem mô tả phòng</p>
            </div>
        </div>
    </div>
    <div style="margin-top:25px;">
        <h3>Phòng cùng khách sạn</h3>
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
                    @foreach ($listRoomHotelExceptId as $keyRoom => $valueRoom)
                        <tr>
                            <td>{{ $valueRoom->room_name }}</td>
                            <td class="py-1"><img src="{{ asset($valueRoom->image_room) }}" width="150px" height="auto" alt="Lỗi tải ảnh"></td>
                            <td>{{ $valueRoom->room_type_name }}</td>
                            <td>{{ $valueRoom->number_people }}</td>
                            <td>{{ number_format($valueRoom->price) }} đ</td>
                            <td>
                                <a href="{{ route('room-detail' , ['id' => $valueRoom->id]) }}"  style="background-color:#86B817;padding:3px 5px;border-radius:3px;color:white;text-decoration:none;">Xem phòng</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
        </table>
    </div>

    <!-- Modal xem mô tả phòng -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Mô tả phòng</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ $roomDetail->description }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('script')
<script>
    function validateCheckRoom() {
        const check_in_date_input = document.querySelector('.check-in-date');
        const check_in_date_err = document.getElementById('check-in-date-err');
        const check_out_date_input = document.querySelector('.check-out-date');
        const check_out_date_err = document.getElementById('check-out-date-err');
        let checkRoom = true;
        let currentDate = new Date();

        let check_in_date = new Date(check_in_date_input.value.trim());
        let check_out_date = new Date(check_out_date_input.value.trim());

        check_in_date.setHours(0, 0, 0, 0); 
        check_out_date.setHours(0, 0, 0, 0); 
        currentDate.setHours(0, 0, 0, 0);

        if (isNaN(check_in_date.getTime())) {
            check_in_date_err.innerText = "Hãy nhập ngày nhận phòng";
            checkRoom = false;
        } else if (currentDate > check_in_date) {
            check_in_date_err.innerText = "Ngày vào phải >= ngày hiện tại";
            checkRoom = false;
        } else {
            check_in_date_err.innerText = "";
        }

        if (isNaN(check_out_date.getTime())) {
            check_out_date_err.innerText = "Hãy nhập ngày trả phòng";
            checkRoom = false;
        } else if (check_in_date >= check_out_date) {
            check_out_date_err.innerText = "Ngày ra phải > ngày vào";
            checkRoom = false;
        } else {
            check_out_date_err.innerText = "";
        }

        return checkRoom;
    }

</script>
@endsection