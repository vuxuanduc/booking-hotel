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
                        <th>Mã phòng</th>
                        <th>Tên khách sạn</th>
                        <th>Loại phòng</th>
                        <th>Tên phòng</th>
                        <th>Số người ở</th>
                        <th>Mô tả phòng</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listRooms as $keyRoom => $valueRoom)
                        <tr>
                            <td>{{ $valueRoom->id }}</td>
                            <td>{{ $valueRoom->hotel->name_hotel }}</td>
                            <td>{{ $valueRoom->roomType->room_type_name }}</td>
                            <td>{{ $valueRoom->room_name }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $valueRoom->number_people }}
                                </span>
                            </td>
                            <td>
                                {!! htmlspecialchars_decode(substr($valueRoom->description , 0 , 20) .'...') !!}
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ number_format($valueRoom->price) }}
                                </span>
                            </td>
                            <td>
                                @if ($valueRoom->status == 1)
                                    <span class="badge bg-success">
                                        Hoạt động
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        Tạm ẩn
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="d-flex">
                                    <a href="{{ route('rooms.edit' , $valueRoom->id) }}" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                    @if (!$valueRoom->checkImagesRoom()->exists() && !$valueRoom->checkReservations()->exists())
                                        <form action="{{ route('rooms.destroy' , $valueRoom->id) }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-warning text-white" onclick="return confirm('Xác nhận xóa ?')"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: flex;justify-content: space-between;" class="mt-2">  
            <div>
                <a href="{{ route('rooms.create') }}" class="btn btn-primary">Thêm mới</a>
            </div>
            <div class="mx-4">
                {{ $listRooms->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    
@endsection

