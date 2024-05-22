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
                        <th>ID</th>
                        <th>Tên khách sạn</th>
                        <th>Số lượt đánh giá</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listRatingsAllHotel as $keyRatingsAllHotel => $valueRatingsAllHotel)
                        <tr>
                            <td>{{ $valueRatingsAllHotel->id }}</td>
                            <td>{{ $valueRatingsAllHotel->name_hotel }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $valueRatingsAllHotel->total_ratings }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('manager-ratings-hotel' , ['hotel_id' => $valueRatingsAllHotel->id]) }}" class="btn btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 mx-4 d-flex justify-content-end">  
            {{ $listRatingsAllHotel->links() }}
        </div>
    </div>
@endsection

@section('script')
    
@endsection

