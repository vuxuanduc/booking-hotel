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
                        <th>Mã đặt</th>
                        <th>Tên khách sạn</th>
                        <th>Tên phòng</th>
                        <th>Tài khoản đặt</th>
                        <th>Ngày đặt</th>
                        <th>Ngày đến</th>
                        <th>Ngày đi</th>
                        <th>Giá</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listReservations as $keyReservation => $valueReservation)
                        <tr>
                            <td>{{ $valueReservation->id }}</td>
                            <td>{{ $valueReservation->name_hotel }}</td>
                            <td>{{ $valueReservation->room_name }}</td>
                            <td>{{ $valueReservation->email }}</td>
                            <td>{{ $valueReservation->reservation_date }}</td>
                            <td>{{ $valueReservation->check_in_date }}</td>
                            <td>{{ $valueReservation->check_out_date }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ number_format($valueReservation->price) . ' đ' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ number_format($valueReservation->total_amount) . ' đ' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'Chờ xác nhận' => 'bg-secondary',
                                        'Chờ thanh toán' => 'bg-warning',
                                        'Đã thanh toán' => 'bg-primary',
                                        'Đã hủy' => 'bg-danger',
                                        'Hoàn thành' => 'bg-success',
                                    ];
                                @endphp

                                <span class="badge {{ $statusClasses[$valueReservation->name_status] ?? 'bg-info' }}">
                                    {{ $valueReservation->name_status }}
                                </span>
                            </td>
                            <td>
                                @if($valueReservation->name_status == "Chờ xác nhận")
                                    <div class="d-flex">
                                        <form action="{{ route('cancel-booking') }}" method="post">
                                            @csrf
                                            @method("PUT")
                                            <input type="hidden" name="reservation_id" value="{{ $valueReservation->id }}">
                                            <button class="btn btn-danger fw-bold" onclick="return confirm('Xác nhận hủy đặt phòng ?')">Hủy</button>
                                        </form>
                                        <form action="{{ route('confirm-booking') }}" method="post" class="mx-1">
                                            @csrf
                                            @method("PUT")
                                            <input type="hidden" name="reservation_id" value="{{ $valueReservation->id }}">
                                            <button class="btn btn-primary fw-bold" onclick="return confirm('Xác nhận đơn đặt phòng ?')">Xác nhận</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: flex;justify-content: end;" class="mt-2">  
            <div class="mx-4">
                {{ $listReservations->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    
@endsection

