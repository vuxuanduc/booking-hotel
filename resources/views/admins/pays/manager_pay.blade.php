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
                        <th>Mã thanh toán</th>
                        <th>Mã đặt phòng</th>
                        <th>Tài khoản đặt</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức thanh toán</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listPays as $keyPay => $valuePay)
                        <tr>
                            <td>{{ $valuePay->id }}</td>
                            <td>{{ $valuePay->reservation_id }}</td>
                            <td>{{ $valuePay->email }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ number_format($valuePay->total_amount) . ' đ' }}
                                </span>
                            </td>
                            <td>{{ $valuePay->pay_info }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: flex;justify-content: end;" class="mt-2">  
            <div class="mx-4">
                {{ $listPays->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    
@endsection

