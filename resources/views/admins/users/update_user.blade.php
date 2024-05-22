@extends('admins.master_layout_admin')

@section('pageTitle')
    {{ $title }}
@endsection


@section('css')
    <style>
        label {
            font-weight: 600 ;
        }

        .form-group span {
            color : red ;
            margin-left: 10px ;
        }
    </style>
@endsection

@section('content')
    @include('admins.layouts.admin_sidebar')

    <div class="height-100">
        <h2 class="mt-3">{{ $title }}</h2>
        <form id="create-user-admin" action="{{ route('users.update' , $userId->id) }}" method="post">
            @csrf
            @method("PUT")
            <div class="row mb-4">
                <div class="col-6">
                    <div class="form-group mt-3">
                        <label for="">Email</label> <span class="error" id="email_err"></span>
                        <input type="text" value="{{ $userId->email }}" name="email" id="email" class="form-control mt-2" placeholder="Email...">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Mật khẩu</label> <span class="error" id="password_err"></span>
                        <input type="password" value="{{ $userId->password }}" name="password" id="password" class="form-control mt-2" placeholder="Mật khẩu...">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Quyền tài khoản</label> 
                        <select name="role_id" id="role" class="form-select mt-2">
                            <option {{ $userId->role_id == 2 ? "selected" : "" }} value="2">Khách hàng</option>
                            <option {{ $userId->role_id == 1 ? "selected" : "" }} value="1">Quản trị</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mt-3">
                        <label for="">Họ và tên</label> <span class="error" id="full_name_err"></span>
                        <input type="text" value="{{ $userId->full_name }}" name="full_name" placeholder="Họ và tên..." id="fullname" class="form-control mt-2">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Số điện thoại</label> <span class="error" id="phone_err"></span>
                        <input type="text" value="{{ $userId->phone }}" placeholder="Số điện thoại..." name="phone" id="phone" class="form-control mt-2">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Trạng thái</label>
                        <select name="status" class="form-select mt-2">
                            <option {{ $userId->status == 1 ? "selected" : "" }} value="1">Hoạt động</option>
                            <option {{ $userId->status == 2 ? "selected" : "" }} value="2">Tạm ẩn</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn text-white fw-bold mt-3" style="background-color: #86B817;">Cập nhật người dùng</button>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#create-user-admin').on('submit', function(event){
                event.preventDefault();

                let email = $('input[name="email"]').val().trim();
                let password = $('input[name="password"]').val().trim();
                let role_id = $('select[name="role_id"]').val().trim();
                let full_name = $('input[name="full_name"]').val().trim();
                let phone = $('input[name="phone"]').val().trim();
                let status = $('select[name="status"]').val();
                let csrfToken = $(this).find('input[name="_token"]').val();
                let actionUrl = $(this).attr('action');

                // Xóa các thông báo lỗi trước đó
                $('.error').text('');

                $.ajax({
                    url: actionUrl,
                    type: 'PUT',
                    data: {
                        role_id: role_id,
                        full_name: full_name,
                        email: email,
                        password: password,
                        phone: phone,
                        status: status,
                        _token: csrfToken
                    },
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = '{{ route("users.index") }}' ;
                    },
                    error: function(error) {
                        if (error.responseJSON && error.responseJSON.errors) {
                            let errors = error.responseJSON.errors;

                            for (let key in errors) {
                                $('#' + key + '_err').text(errors[key][0]);
                            }
                        } else {
                            
                            console.error("Error occurred, but no error data returned.");
                        }
                    }
                });
            });
        });
    </script>
@endsection