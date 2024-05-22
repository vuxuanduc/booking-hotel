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
        <form id="update-room-type-admin" action="{{ route('room-types.update' , $roomType->id) }}" method="post">
            @csrf
            @method("PUT")
            <div class="form-group" style="padding-right: 30px;">
                <label for="">Tên loại phòng </label> <span style="color:red;" id="room_type_name_err" class="error"></span>
                <input type="text" value="{{ $roomType->room_type_name }}" class="form-control mt-2" id="room_type_name" placeholder="Tên loại phòng..." name="room_type_name">
            </div>
            <button type="submit" class="btn text-white fw-bold mt-3" style="background-color: #86B817;">Cập nhật loại phòng</button>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#update-room-type-admin').on('submit' , function(event){
                event.preventDefault() ;

                let room_type_name = $('#room_type_name').val().trim() ;
                let _token = $(this).find('input[name="_token"]').val() ;
                let actionUrl = $(this).attr('action') ;
                
                $('.error').text('');

                $.ajax({
                    url : actionUrl ,
                    type : "PUT" ,
                    data : {
                        room_type_name : room_type_name ,
                        _token : _token 
                    } ,
                    dataType : 'json' ,
                    success : function(response) {
                        window.location.href = '{{ route("room-types.index") }}' ;
                    } ,
                    error : function(error) {
                        if (error.responseJSON && error.responseJSON.errors) {
                            let errors = error.responseJSON.errors;

                            for (let key in errors) {
                                $('#' + key + '_err').text(errors[key][0]);
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