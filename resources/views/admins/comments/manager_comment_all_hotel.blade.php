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
                        <th>STT</th>
                        <th>Tên khách sạn</th>
                        <th>Số lượt bình luận</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listCommentsAllHotel as $keyCommentsAllHotel => $valueCommentsAllHotel)
                        <tr>
                            <td>{{ $valueCommentsAllHotel->id }}</td>
                            <td>{{ $valueCommentsAllHotel->name_hotel }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $valueCommentsAllHotel->total_comments }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('manager-comments-hotel' , ['hotel_id' => $valueCommentsAllHotel->id]) }}" class="btn btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 mx-4 d-flex justify-content-end">  
            {{ $listCommentsAllHotel->links() }}
        </div>
    </div>
@endsection

@section('script')
    
@endsection

