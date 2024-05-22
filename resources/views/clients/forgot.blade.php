@extends('clients.master_layout_client') 
@section('pageTitle')
    {{ $title }}
@endsection
@section('css')
    <style>
        #forgot {
            background-image: url('http://localhost/bookingHotel/public/images/banner%203.jpg');
        }
    </style>
@endsection
@section('content')
    <div id="forgot">
        <form style="width:400px;" id="form-forgot" action="{{ route('forgot-processing') }}" method="post">
            <h4 class="text-center my-2">QUÊN MẬT KHẨU</h4>
            @csrf
            <div class="form-group">
                <label for="">Email</label> <span style="color:red;margin-left: 5px;" id="email_err"></span>
                <input type="text" id="email" name="email" class="form-control my-2">
            </div>
            <div class="form-group">
                <input type="submit" value="Gửi" class="form-control btn btn-primary my-2">
            </div>
            <div class="form-group">
                <a href="{{ route('signup') }}">Đăng ký</a>
                <a href="{{ route('login') }}">Đăng nhập</a>
            </div>
        </form>
    </div>
    <!-- Button trigger modal -->
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
            <p class="text-center">Mật khẩu mới đã được gửi về email của bạn.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
          <a href="{{ route('login') }}" class="btn" style="background-color: #86B817;color:white;">Đăng nhập</a>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#form-forgot').on('submit' , function(event) {
                event.preventDefault() ;
                let email = $('#email').val().trim() ;
                let _token = $(this).find('input[name="_token"]').val() ;
                let url = $(this).attr('action') ;

                $('#email_err').text('') ;

                $.ajax({
                    url : url ,
                    type : "POST" ,
                    data : {
                        email : email ,
                        _token : _token ,
                    } ,
                    dataType : 'json' ,
                    success : function(response) {
                        $('#notification').click() ;
                        $('#form-forgot')[0].reset() ;
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