@extends('clients.master_layout_client') 
@section('pageTitle')
    {{ $title }}
@endsection
@section('css')
    <style>
        .box-profile {
            margin-top : 10px ;
            display: grid ;
            grid-template-columns: 1fr 2.5fr;
            gap : 20px ;
        }
        @media (width < 575px) {
            .box-profile {
                display: grid ;
                grid-template-columns: 1fr;
                gap : 20px ;
            }
        }
        .nav-profile {
            padding: 0 ;
            list-style : none;
            margin-top : 2px ;
        }
        .nav-profile li {
            padding: 5px 5px ;
        }
        .nav-profile li a {
            text-decoration: none;
            color : black ;
            
        }
        .nav-profile li:hover {
            background-color : #4790cd ;
        }
        .nav-profile li:hover a {
            color : white ;
        }
        .profile-user {
            border : 1px solid #86B817 ;
            padding-bottom : 10px ;
        }
        .profile-user div {
            width : 80% ;
            margin-left : 50% ;
            transform : translateX(-50%) ;
        }
        .profile-user label{
            font-weight : 500 ;
        }
        .profile-user a {
            text-decoration: none;
            cursor: pointer;
        }
        .card-title {
            
            padding: 5px 10px;
        }
        .card-title-1 {
            background-color : #4790cd;
            color : white ;
        }
        .fa-id-card  , .fa-user {
            padding-right : 10px ;
        }
        .card-title-2 {
            color : #86B817 ;
        }
        .validate_err {
            color :red ;
            margin-left : 4px ;
        }
        #btn-update-profile {
            background-color : #86B817 ;
            color : white ;
        }
    </style>
@endsection
@section('content')
    <div class="box-profile px-1">
        <div class="card-1">
            <h5 class="card-title card-title-1">Thông tin thành viên</h5>
            <ul class="nav-profile">
                <li><a href="{{ route('profile') }}">Thông tin cá nhân</a></li>
                <li><a href="{{ route('history-booking') }}">Lịch sử đặt phòng</a></li>
                <li><a href="{{ route('logout') }}">Đăng xuất</a></li>
            </ul>
        </div>
        <div class="">
            <div class="profile-user">
                <h5 class="card-title card-title-2"><i class="fa-solid fa-id-card"></i>Thông tin tài khoản</h5>
                <hr>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" value="{{ session('email') }}" class="form-control my-2" readonly>
                </div>
                <div class="form-group">
                    <label for="">Mật khẩu</label>
                    <input type="password" value="{{ $user->password }}" class="form-control my-2" readonly>
                    <a data-bs-toggle="modal" data-bs-target="#staticBackdrop">Đổi mật khẩu</a>
                </div>
            </div>

            <!-- Modal đổi mật khẩu -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('change-password') }}" method="post" id="form-change-password">
                            @csrf
                            @method("PUT")
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Đổi mật khẩu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Mật khẩu cũ</label> <span class="error-change-password validate_err" id="old_password_err"></span>
                                    <input type="password" id="old_password" name="old_password" class="form-control my-2">
                                </div>
                                <div class="form-group">
                                    <label for="">Mật khẩu mới</label> <span class="error-change-password validate_err" id="new_password_err"></span>
                                    <input type="password" id="new_password" name="new_password" class="form-control my-2">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn text-white" style="background-color: #86B817;">Lưu thay đổi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="profile-user my-3">
                <h5 class="card-title card-title-2"><i class="fa-solid fa-user"></i></i>Thông tin thành viên</h5>
                <hr>
                <form action="{{ route('change-info') }}" method="post" id="form-change-info">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="">Email liên lạc</label>
                        <input type="text" value="{{ session('email') }}" class="form-control my-2" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Số điện thoại</label> <span class="validate_err error-change-info" id="phone_err"></span>
                        <input type="text" value="{{ $user->phone }}"  class="form-control my-2" name="phone" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="">Họ và tên</label> <span class="validate_err error-change-info" id="full_name_err"></span>
                        <input type="text"  value="{{ $user->full_name }}" name="full_name" class="form-control my-2" id="fullname">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Lưu thông tin" id="btn-update-profile"  class="btn my-2">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <button type="button" id="notification" style="display: none;" data-bs-toggle="modal" data-bs-target="#exampleModal"></button>
  
  <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-start">
                    <i class="fa-solid fa-check"></i>
                    <h2 class="modal-title fs-5 mx-1" id="exampleModalLabel">Thông báo</h2>
                </div>
                <div class="modal-body">
                    <p class="text-center">Cập nhật thông tin thành công</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Xử lí dữ liệu form thay đổi mật khẩu ;
        $(document).ready(function(){
            $('#form-change-password').on('submit' , function(event) {
                event.preventDefault() ;
                let oldPassword = $('#old_password').val().trim() ;
                let newPassword = $('#new_password').val().trim() ;
                let _token = $(this).find('input[name="_token"]').val() ;
                let url = $(this).attr('action') ;

                $('.error-change-password').text('') ;

                $.ajax({
                    url : url ,
                    type : "PUT" ,
                    data : {
                        old_password : oldPassword ,
                        new_password : newPassword ,
                        _token : _token ,
                    } ,
                    dataType : 'json' ,
                    success : function(response) {
                        $('#form-change-password')[0].reset() ;
                        $('.btn-close').click() ;
                        $('#notification').click() ;
                    } ,
                    error : function(error) {
                        if(error.responseJSON && error.responseJSON.errors) {
                            let errors = error.responseJSON.errors ;
                            for(let key in errors) {
                                $('#' + key + '_err').text(errors[key][0]) ;
                            }
                        }else {
                            console.error("Error occurred, but no error data returned.")
                        }
                    }
                })
            }) ;

            // Xử lí thay đổi thông tin cá nhân ;
            $('#form-change-info').on('submit' , function(event) {
                event.preventDefault() ;
                let phone = $('#phone').val().trim() ;
                let full_name = $('#fullname').val().trim() ;
                let _token = $(this).find('input[name="_token"]').val() ;
                let url = $(this).attr('action') ;

                $('.error-change-info').text('') ;

                $.ajax({
                    url : url ,
                    type : "PUT" ,
                    data : {
                        phone : phone ,
                        full_name : full_name ,
                        _token : _token
                    } ,
                    dataType : 'json' ,
                    success : function(response) {
                        $('#notification').click() ;
                    } ,
                    error : function(error) {
                        if(error.responseJSON && error.responseJSON.errors) {
                            let errors = error.responseJSON.errors ;
                            for(let key in errors) {
                                $('#' + key + '_err').text(errors[key][0])
                            }
                        }else {
                            console.error("Error occurred, but no error data returned.")
                        }
                    }
                })
            }) ;
        })

        
    </script>
@endsection