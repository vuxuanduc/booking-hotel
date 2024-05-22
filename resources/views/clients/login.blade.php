@extends('clients.master_layout_client') 
@section('pageTitle')
    {{ $title }}
@endsection
@section('css')
    <style>
        #login {
            background-image: url('http://localhost/bookingHotel/public/images/banner%201.jpg');
        }
    </style>
@endsection
@section('content')
<div id="login">
    <form action="{{ route('login-processing') }}" style="width: 400px;" method="post" id="form-login">
        @csrf
        <h4 class="text-center my-2">ĐĂNG NHẬP</h4>
        <div class="form-group">
            <label for="">Email</label> <span style="color : red;margin-left: 5px;" id="email_err" class="error"></span>
            <input type="text" id="email" name="email" class="form-control my-2">
        </div>
        <div class="form-group">
            <label for="">Mật khẩu</label> <span style="color:red;margin-left: 5px;" id="password_err" class="error"></span>
            <input type="password" name="password" id="password" class="form-control my-2">
        </div>
        <div class="form-group">
            <input type="submit" value="Đăng nhập" class="form-control btn btn-primary my-2">
        </div>
        <div class="form-group">
            <a href="{{ route('signup') }}">Đăng ký</a>
            <a href="{{ route('forgot') }}">Quên mật khẩu</a>
        </div>
    </form>
</div>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#form-login').on('submit' , function(event){
                event.preventDefault() ;
                
                let email = $('#email').val().trim() ;
                let password = $('#password').val().trim() ;
                let _token = $(this).find('input[name="_token"]').val() ;
                let url = $(this).attr('action') ;

                $('.error').text('') ;

                $.ajax({
                    url : url ,
                    type : "POST" ,
                    data : {
                        email : email ,
                        password : password ,
                        _token : _token ,
                    } ,
                    dataType : 'json' ,
                    success : function(response) {
                        window.location.href = ' {{ route("/") }} ' ;
                    } ,
                    error : function(error) {
                        if(error.responseJSON && error.responseJSON.errors) {
                            let errors = error.responseJSON.errors ;
                            for(let key in errors) {
                                $('#' + key + '_err').text(errors[key][0]) ;
                            }
                        } else {
                            console.error("Error occurred, but no error data returned.");
                        }
                    }
                })
            })
        })
    </script>
@endsection