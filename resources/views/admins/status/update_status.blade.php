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
        <form id="update-status-admin" action="{{ route('statuses.update' , $status->id) }}" method="post">
            @csrf
            @method("PUT")
            <div class="form-group" style="padding-right: 30px;">
                <label for="">Tên trạng thái </label> <span style="color:red;" id="name_status_err" class="error"></span>
                <input type="text" value="{{ $status->name_status }}" class="form-control mt-2" id="name_status" placeholder="Tên trạng thái..." name="name_status">
            </div>
            <button type="submit" class="btn text-white fw-bold mt-3" style="background-color: #86B817;">Cập nhật trạng thái</button>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#update-status-admin').on('submit' , function(event){
                event.preventDefault() ;

                let name_status = $('#name_status').val().trim() ;
                let _token = $(this).find('input[name="_token"]').val() ;
                let actionUrl = $(this).attr('action') ;
                
                $('.error').text('');

                $.ajax({
                    url : actionUrl ,
                    type : "PUT" ,
                    data : {
                        name_status : name_status ,
                        _token : _token 
                    } ,
                    dataType : 'json' ,
                    success : function(response) {
                        window.location.href = '{{ route("statuses.index") }}' ;
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