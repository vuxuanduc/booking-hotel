@extends('admins.master_layout_admin')

@section('pageTitle')
    {{ $title }}
@endsection

@section('css')
    <style>
        .table-wrapper {
            overflow-x: auto; 
            width: 100%; 
        }

        /* Thiết lập table */
        .table {
            width: 100%; 
            white-space: nowrap; 
        }

        .table-wrapper::-webkit-scrollbar {
            height: 7px; 
        }
        
        .table-wrapper::-webkit-scrollbar-thumb {
            background-color: #a1a1a1; 
            border-radius: 6px; 
        }
        
        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background-color: #808080; 
        }

    </style>
@endsection
    
@section('content')
    @include('admins.layouts.admin_sidebar')
    <div class="height-100">
        <h2 class="mt-1">{{ $title }}</h2>
        <div class="table-wrapper">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Mã ảnh</th>
                        <th>Hình ảnh</th>
                        <th>Đường dẫn ảnh</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listImages as $keyImage => $valueImage)
                        <tr>
                            <td>{{ $valueImage->id }}</td>
                            <td>
                                <img src="{{ asset($valueImage->image_room) }}" width="120px" height="auto" alt="">
                            </td>
                            <td>
                                {{ $valueImage->image_room }}
                            </td>
                            <td>
                                <form action="{{ route('delete-image-room' , ['image_id' => $valueImage->id]) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-warning text-white" onclick="return confirm('Xác nhận xóa ?')"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 d-flex justify-content-start">  
            <a href="{{ route('create-image-room' , ['room_id' => $room_id]) }}" class="btn btn-primary">Thêm ảnh</a>
        </div>
    </div>
@endsection

@section('script')
    
@endsection

