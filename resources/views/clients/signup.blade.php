@extends('clients.master_layout_client') 
@section('pageTitle')
    {{ $title }}
@endsection
@section('css')
    <style>
        #signup {
            background-image: url('http://localhost/bookingHotel/public/images/banner%202.jpg');
        }
    </style>
@endsection
@section('content')
    <div id="signup">
        <form id="form-signup" style="width: 400px;" action="{{ route('signup-processing') }}" method="post">
            <h4 class="text-center my-2">ĐĂNG KÝ</h4>
            @csrf
            <div class="form-group">
                <label for="">Email</label> <span style="color:red;margin-left: 5px;" id="email_err" class="error"></span>
                <input type="text" id="email" name="email" class="form-control my-2">
            </div>
            <div class="form-group">
                <label for="">Mật khẩu</label> <span style="color:red;margin-left: 5px;" id="password_err" class="error"></span>
                <input type="password" id="password" name="password" class="form-control my-2">
            </div>
            <div class="form-group">
                <label for="">Nhập lại mật khẩu</label> <span style="color:red;margin-left: 5px;" id="confirm_password_err" class="error"></span>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control my-2">
            </div>
            <div class="form-group">
                <input type="submit" value="Đăng ký" class="form-control btn btn-primary my-2">
            </div>
            <div class="form-group">
                <a href="{{ route('login') }}">Đăng nhập</a>
                <a href="{{ route('forgot') }}">Quên mật khẩu</a>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#form-signup').on('submit' , function(event){
                event.preventDefault() ;

                let email = $('#email').val().trim() ;
                let password = $('#password').val().trim() ;
                let confirm_password = $('#confirm_password').val().trim() ;
                let _token = $(this).find('input[name="_token"]').val() ;
                let url = $(this).attr('action') ;

                $('.error').text('') ;

                $.ajax({
                    url : url ,
                    type : "POST" ,
                    data : {
                        email : email ,
                        password : password ,
                        confirm_password : confirm_password ,
                        _token : _token ,
                    } ,
                    dataType : 'json' ,
                    success : function(response) {
                        window.location.href = ' {{ route("login") }} ' ;
                    } ,
                    error : function(error) {
                        if(error.responseJSON && error.responseJSON.errors) {
                            let errors = error.responseJSON.errors ;
                            for(let key in errors) {
                                $('#' + key + '_err').text(errors[key][0]) ;
                            }
                        }else {
                            console.error("Đã xảy ra lỗi , không tìm thấy dữ liệu trả về") ;
                        }
                    }
                })
            })
        })
    </script>
@endsection