@extends('admins.master_layout_admin')

@section('pageTitle')
    {{ $title }}
@endsection

@section('TinyMCE')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.0.0/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '.tinymce' ,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
        });
    </script>
@endsection

@section('css')
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        label {
            font-weight: 600 ;
        }

        .form-group span  , #description_err {
            color : red ;
            margin-left: 6px ;
        }
    </style>
@endsection

@section('content')
    @include('admins.layouts.admin_sidebar')

    <div class="height-100">
        <h2 class="mt-3">{{ $title }}</h2>
        <form id="form-update-room" action="{{ route('rooms.update' , $room->id) }}" method="post">
            @csrf
            @method("PUT")
            <div class="row mb-4">
                <div class="col-6">
                    <div class="form-group mt-3">
                        <label for="">Chọn khách sạn</label> <span id="hotel_id_err" class="error"></span>
                        <select id="hotel_id" name="hotel_id" class="form-select mt-2">
                            <option value="">Chọn khách sạn</option>
                            @foreach ($listHotels as $keyHotel => $valueHotel)
                                <option {{ $room->hotel_id == $keyHotel ? "selected" : "" }} value="{{ $keyHotel }}">{{ $valueHotel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Chọn loại phòng</label> <span id="room_type_id_err" class="error"></span>
                        <select id="room_type_id" name="room_type_id" class="form-select mt-2">
                            <option value="">Chọn loại phòng</option>
                            @foreach ($listRoomTypes as $keyRoomType => $valueRoomType)
                                <option {{ $room->room_type_id == $keyRoomType ? "selected" : "" }} value="{{ $keyRoomType }}">{{ $valueRoomType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Tên phòng</label> <span id="room_name_err" class="error"></span>
                        <input type="text" value="{{ $room->room_name }}" placeholder="Tên phòng..." id="room_name" name="room_name" class="form-control mt-2">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mt-3">
                        <label for="">Số lượng người</label> <span id="number_people_err" class="error"></span>
                        <input type="text" value="{{ $room->number_people }}" placeholder="Số lượng người..." name="number_people" id="number_people" class="form-control mt-2">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Giá phòng</label> <span id="price_err" class="error"></span>
                        <input type="text" value="{{ $room->price }}" placeholder="Giá phòng..." name="price" id="price" class="form-control mt-2">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Trạng thái phòng</label> <span id="status_err" class="error"></span>
                        <select id="status" name="status" class="form-select mt-2">
                            <option {{ $room->status == 1 ? "selected" : "" }} value="1">Hoạt động</option>
                            <option {{ $room->status == 2 ? "selected" : "" }} value="2">Tạm ẩn</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <label for="" class="my-2">Mô tả phòng</label> <span id="description_err" class="error"></span>
                <textarea class="tinymce" name="description" id="description" cols="30" rows="20">
                    {{ $room->description }}
                </textarea>
            </div>
            <button id="btn-update-room" type="submit" class="btn text-white fw-bold mt-3" style="background-color: #86B817;">Cập nhật phòng</button>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#form-update-room').on('submit' , function(event) {
                event.preventDefault() ;
                let hotel_id = $('select[name="hotel_id"]').val() ;
                let room_type_id = $('select[name="room_type_id"]').val() ;
                let room_name = $('input[name="room_name"]').val().trim() ;
                let number_people = $('input[name="number_people"]').val().trim() ;
                let price = $('input[name="price"]').val().trim() ;
                let status = $('select[name="status"]').val() ;
                let description = $('textarea[name="description"]').val().trim() ;
                let _token = $(this).find('input[name="_token"]').val() ;
                let url = $(this).attr('action') ;

                $('.error').text('') ;

                $.ajax({
                    url : url ,
                    type : "PUT" ,
                    data : {
                        hotel_id : hotel_id ,
                        room_type_id : room_type_id ,
                        room_name : room_name ,
                        number_people : number_people ,
                        description : description ,
                        price : price ,
                        status : status ,
                        _token : _token ,
                    } ,
                    dataType : 'json' ,
                    success : function(response) {
                        window.location.href = '{{ route("rooms.index") }}' ;
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