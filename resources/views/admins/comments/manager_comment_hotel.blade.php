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
                        <th>Nội dung</th>
                        <th>Ngày bình luận</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listComments as $keyComment => $valueComment)
                        <tr>
                            <td>{{ $valueComment->id }}</td>
                            <td>{{ $valueComment->email }}</td>
                            <td>{{ $valueComment->content_comment }}</td>
                            <td>{{ $valueComment->date_comment }}</td>
                            <td>
                                @if ($valueComment->status == 1)
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
                                @if ($valueComment->status == 1)
                                    <form action="{{ route('hidden-comment' , ['comment_id' => $valueComment->id]) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <button class="btn btn-warning text-white"><i class="fa-solid fa-eye-slash"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('show-comment' , ['comment_id' => $valueComment->id]) }}" method="post">
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
            {{ $listComments->links() }}
        </div>
    </div>
@endsection

@section('script')
    
@endsection

