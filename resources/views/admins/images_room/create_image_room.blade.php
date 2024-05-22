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
        <form onsubmit="return checkImage();" action="{{ route('store-image-room') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $room_id }}" name="room_id">
            <div class="form-group" style="padding-right: 30px;">
                <label for="">Chọn ảnh </label> <span style="color:red;" id="image_room_err" class="error"></span>
                <input type="file" class="form-control mt-2" id="image_room" name="image_room[]" multiple accept="image/*">
            </div>
            <button type="submit" class="btn text-white fw-bold mt-3" style="background-color: #86B817;">Thêm ảnh</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        function checkImage() {
            let image_room = document.getElementById('image_room');
            let check = true;
            let maxSizeInBytes = 5242880; // 5MB
            let totalSize = 0;
            
            if (!image_room || !image_room.files || image_room.files.length === 0) {
                document.querySelector('.error').textContent = "Vui lòng tải ảnh lên";
                check = false;
            } else {
                for (let i = 0; i < image_room.files.length; i++) {
                    let fileSize = image_room.files[i].size; 
                    totalSize += fileSize;
                }
                
                if (totalSize > maxSizeInBytes) {
                    document.querySelector('.error').textContent = "Kích thước ảnh không được quá 5mb";
                    check = false;
                } else {
                    document.querySelector('.error').textContent = "";
                }
            }
            return check;
        }
    </script>
    
@endsection