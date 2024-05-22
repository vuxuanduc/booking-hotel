@extends('clients.master_layout_client') 
@section('pageTitle')
    {{ $title }}
@endsection
@section('css')
    <style>
        #forgot {
            background-image: url('http://localhost/bookingHotel/public/images/banner%203.jpg');
        }
        .notification {
            width : 350px ;
            background-color: #fff;
            position: absolute;
            top : 50% ;
            left : 50% ;
            transform: translate(-50% , -50%);
            border-radius: 10px;
            padding: 0 25px;
            padding-bottom: 25px;
            padding-top: 10px;
        }
        .fa-check {
            margin-left: 50%;
            transform: translateX(-50%) ;
        }
    </style>
@endsection
@section('content')
<div id="forgot">
    <div class="notification">
        <h5 class="text-center">Thông báo</h5>
        <i class="fa-solid fa-check"></i>
        <p class="text-center">Mật khẩu đã được gửi về email của bạn. Đăng nhập <a href="{{ route('login') }}" style="text-decoration: none;">tại đây</a></p>
    </div>
</div>
@endsection
@section('script')

@endsection