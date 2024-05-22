<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('pageTitle')</title>
    <link rel="shortcut icon" href="{{ asset('images/2-removebg-preview.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


</head>

<body>
    <div class="container">
        <header class="header">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('/') }}"><img class="logo" src="{{ asset('images/2-removebg-preview.png') }}" alt="Lỗi tải ảnh"></a>
                    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon text-white"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-white" aria-current="page" href="{{ route('/') }}">Trang chủ</a>
                            </li>
                
                            <li class="nav-item dropdown">
                                <a class="text-white nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  Khách sạn
                                </a>
                              
                                <div class="dropdown-menu">
                                    <a style="font-size:15px;" class="dropdown-item" href="{{ route('all-hotel') }}">Tất cả khách sạn</a>
                                    <a style="font-size:15px;" class="dropdown-item" href="{{ route('top-booking-hotel') }}">Top đặt phòng</a>
                                    <a style="font-size:15px;" class="dropdown-item" href="{{ route('top-view-hotel') }}">Top lượt xem</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white btn-contact" aria-current="page" data-bs-toggle="modal" data-bs-target="#modalContact">Liên hệ</a>
                            </li>
                            <li class="nav-item dropdown search-room">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tìm phòng
                                </a>
                                <div class="dropdown-menu px-3" aria-labelledby="navbarDropdown">
                                    <form action="?action=searchHotel" method="post" onsubmit="return validatesSearch();">
                                        <div class="form-group">
                                            <label for="">KHÁCH SẠN</label>
                                            <input style="height:30px;" type="text" name="nameHotel" id="nameHotel" placeholder="Tên khách sạn..." class="form-control my-2">
                                        </div>
                                        <div class="form-group">
                                            <label for="">NGÀY NHẬN PHÒNG</label>
                                            <input style="height:30px;" name="checkIn" id="checkIn" type="date" class="form-control my-2">
                                        </div>
                                        <div class="form-group">
                                            <label for="">NGÀY TRẢ PHÒNG</label>
                                            <input style="height:30px;" name="checkOut" id="checkOut" type="date" class="form-control my-2">
                                        </div>
                                        <div class="form-group">
                                            <label for="">SỐ NGƯỜI</label>
                                            <input style="height:30px;" name="quantity" id="quantity" type="number" min="0" step="1" class="form-control my-2">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" value="TÌM PHÒNG" name="btn-search-room" class="form-control my-3" style="background-color:#86B817;color:white;">
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                        @if (session()->has('email'))
                            <div class="nav-item dropdown">
                                <a class="text-white nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ 'Xin chào ' . session('email')}}
                                </a>
                            
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('profile') }}">Thông tin tài khoản</a>
                                    <a class="dropdown-item" href="{{ route('history-booking') }}">Lịch sử đặt phòng</a>
                                    @if (session('role_id') == 1) 
                                        <a class="dropdown-item" href="{{ route('dashboard') }}">Trang quản lí</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}">Đăng xuất</a>
                                </div>
                            </div>
                        @else 
                            <div class="nav-item dropdown profile">
                                <a class="nav-link text-white" href="{{ route('login') }}">Đăng nhập</a>
                            </div>
                        @endif
                        
                    </div>
                </div>
            </nav>
            
            <div class="modal fade" id="modalContact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thông tin liên hệ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>GỌI CHO CHÚNG TÔI</h5>
                        <p><span>Tổng đài : </span><span><strong>028 73030 588 - 028 3925 1055</strong></span></p>
                        <p><span>Cá nhân : </span><span><strong>0902 606 953 - 0902 329 215</strong></span></p>
                        <h5>ĐỊA CHỈ VĂN PHÒNG</h5>
                        <p>Tầng 10, số 60 Nguyễn Đình Chiểu, Phường Đa Kao, Quận 1, Tp Hồ Chí Minh.</p> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="background-color: #86B817;color:white;" class="btn" data-bs-dismiss="modal">OK</button>
                    </div>
                    </div>
                </div>
            </div>
        </header>