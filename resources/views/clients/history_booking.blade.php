@extends('clients.master_layout_client') 
@section('pageTitle')
    {{ $title }}
@endsection
@section('css')
    <style>
        .box-profile {
        margin-top : 10px ;
        display: grid ;
        grid-template-columns: 1fr 2.5fr;
        gap : 20px ;
        }
        @media (width < 575px) {
            .box-profile {
                display: grid ;
                grid-template-columns: 1fr;
                gap : 20px ;
            }
        }
        .nav-profile {
            padding: 0 ;
            list-style : none;
            margin-top : 2px ;
        }
        .nav-profile li {
            padding: 5px 5px ;
        }
        .nav-profile li a {
            text-decoration: none;
            color : black ;
            
        }
        .nav-profile li:hover {
            background-color : #4790cd ;
        }
        .nav-profile li:hover a {
            color : white ;
        }
        
        .card-title {
            
            padding: 5px 10px;
        }
        .card-title-1 {
            background-color : #4790cd;
            color : white ;
        }
        
        .btn {
            font-size : 10px ;
        }
        .table-background {
            background-color : #86B817;
        }
        .table-background tr th {
            color : white ;
            font-weight : 400 ;
        }
        .btn-pay {
            background-color : #ea4aaa ;
            color : white ;
        }
    </style>
@endsection
@section('content')
<div class="box-profile px-1">
    <div class="card-1">
        <h5 class="card-title card-title-1">Lịch sử đặt phòng</h5>
        <ul class="nav-profile">
            <li><a href="{{ route('profile') }}">Thông tin cá nhân</a></li>
            <li><a href="{{ route('history-booking') }}">Lịch sử đặt phòng</a></li>
            <li><a href="{{ route('logout') }}">Đăng xuất</a></li>
        </ul>
    </div>
    <div class="">
        <table class="table table-hover">
            <thead class="table-background">
                <tr>
                    <th>Tên phòng</th>
                    <th>Ngày đặt</th>
                    <th>Ngày vào</th>
                    <th>Ngày ra</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($historyBooking as $keyHistory => $valueHistory)
                    <tr>
                        <td>{{ $valueHistory->room_name }}</td>
                        <td>{{ date('H:i:s d-m-Y' , strtotime($valueHistory->reservation_date)) }}</td>
                        <td>{{ date('d-m-Y' , strtotime($valueHistory->check_in_date)) }}</td>
                        <td>{{ date('d-m-Y' , strtotime($valueHistory->check_out_date)) }}</td>
                        <td>
                            <span class="badge bg-info">
                                {{ number_format($valueHistory->total_amount) .'đ' }}
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

                            <span class="badge {{ $statusClasses[$valueHistory->name_status] ?? 'bg-info' }}">
                                {{ $valueHistory->name_status }}
                            </span>
                        </td>
                        <td>
                            @if($valueHistory->name_status == "Chờ xác nhận")
                                <form action="{{ route('cancel-booking') }}" method="post">
                                    @csrf
                                    @method("PUT")
                                    <input type="hidden" name="reservation_id" value="{{ $valueHistory->id }}">
                                    <button class="btn btn-danger fw-bold" onclick="return confirm('Xác nhận hủy đặt phòng ?')">Hủy</button>
                                </form>
                            @elseif($valueHistory->name_status == "Chờ thanh toán")
                                <div class="d-flex">
                                    <form action="{{ route('cancel-booking') }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <input type="hidden" name="reservation_id" value="{{ $valueHistory->id }}">
                                        <button class="btn btn-danger fw-bold" onclick="return confirm('Xác nhận hủy đặt phòng ?')">Hủy</button>
                                    </form>
                                    <form action="{{ route('payment-vnpay') }}" method="post" class="mx-1">
                                        @csrf
                                        <input type="hidden" name="reservation_id" value="{{ $valueHistory->id }}">
                                        <button name="redirect" style="background-color: #4a7fea;" class="btn text-white fw-bold">VnPay</button>
                                    </form>
                                </div>
                            @endif 
                        </td>
                    </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>
</div>
@endsection
@section('script')
    
@endsection