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
                        <th>Tên người dùng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Phân quyền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listUsers as $keyUser => $valueUser)
                        <tr>
                            <td>{{ $valueUser->id }}</td>
                            <td>
                                @if ($valueUser->full_name == "")
                                    <span>Đang cập nhật</span>
                                @else
                                    <span>{{ $valueUser->full_name }}</span>
                                @endif
                            </td>
                            <td>{{ $valueUser->email }}</td>
                            <td>
                                @if ($valueUser->phone == "")
                                    <span>Đang cập nhật</span>
                                @else
                                    <span>{{ $valueUser->phone }}</span>
                                @endif
                            </td>
                            <td>{{ $valueUser->role->name_role }}</td>
                            <td>
                                @if ($valueUser->status == 1)
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
                                    <a href="{{ route('users.edit' , $valueUser->id) }}" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                    @if (!$valueUser->comments()->exists() && !$valueUser->reservations()->exists())
                                        <form action="{{ route('users.destroy' , $valueUser->id) }}" method="post">
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
                <a href="{{ route('users.create') }}" class="btn btn-primary">Thêm mới</a>
            </div>
            <div class="mx-4">
                {{ $listUsers->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    
@endsection

