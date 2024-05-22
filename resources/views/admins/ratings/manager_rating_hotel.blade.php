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
                        <th>Tài khoản</th>
                        <th>Điểm đánh giá</th>
                        <th>Nội dung</th>
                        <th>Ngày đánh giá</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listRatings as $keyRating => $valueRating)
                        <tr>
                            <td>{{ $valueRating->id }}</td>
                            <td>{{ $valueRating->email }}</td>
                            <td>{{ $valueRating->rating }}</td>
                            <td>{{ $valueRating->content_rating }}</td>
                            <td>{{ $valueRating->date_rating }}</td>
                            <td>
                                @if ($valueRating->status == 1)
                                    <span class="badge bg-success">
                                        Hiển thị
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        Tạm ẩn
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($valueRating->status == 1)
                                    <form action="{{ route('hidden-rating' , ['rating_id' => $valueRating->id]) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <button class="btn btn-warning text-white"><i class="fa-solid fa-eye-slash"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('show-rating' , ['rating_id' => $valueRating->id]) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <button class="btn btn-primary text-white"><i class="fa-solid fa-eye"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 mx-4 d-flex justify-content-end">  
            {{ $listRatings->links() }}
        </div>
    </div>
@endsection

@section('script')
    
@endsection

