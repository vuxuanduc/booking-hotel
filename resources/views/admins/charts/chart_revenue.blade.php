@extends('admins.master_layout_admin')

@section('pageTitle')
    {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .chart-wrapper {
            overflow-x: auto; 
            width: 100%; 
        }

        /* Thiết lập table */
        .chart {
            width: 100%; 
            white-space: nowrap; 
        }

        .chart-wrapper::-webkit-scrollbar {
            height: 7px; 
        }
        
        .chart-wrapper::-webkit-scrollbar-thumb {
            background-color: #a1a1a1; 
            border-radius: 6px; 
        }
        
        .chart-wrapper::-webkit-scrollbar-thumb:hover {
            background-color: #808080; 
        }

    </style>
@endsection
    
@section('content')
    @include('admins.layouts.admin_sidebar')
    <div class="height-100">
        <h2 class="mt-1">{{ $title }}</h2>
        <div class="chart-wrapper">
            <div class="form-chart row mt-2">
                <form class="col-4">
                    <div class="row">
                        <div class="form-group">
                            <select class="form-select" id="select-time">
                                <option value="">Chọn thời gian thống kê</option>
                                <option value="day">Thống kê theo ngày</option>
                                <option value="month">Thống kê theo tháng</option>
                                <option value="year">Thống kê theo năm</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="col-8">
                    <form action="{{ route('post-chart-revenue') }}" method="post" id="revenue" class="px-2">
                        
                    </form>
                </div>
            </div>
            <div class="chart mt-2" id="chart">

            </div>
        </div>
        <div class="mt-4 mx-4 d-flex justify-content-end">  
            <a href="{{ route('chart-bookings') }}" class="btn btn-primary">Thống kê đặt phòng</a>
        </div>
    </div>
@endsection

@section('script')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        new Morris.Bar({
            element: 'chart',
            
            data: [
                @foreach($resultRevenue as $keyRevenue => $valueRevenue)
                    { Name: '{{ $valueRevenue->name_hotel }}', value: {{ $valueRevenue->total_revenue }} },
                @endforeach
            ],

            xkey: 'Name',  
            ykeys: ['value'],
            labels: ['Tổng thu']
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const select_time = document.getElementById('select-time') ;
        const revenue = document.getElementById('revenue') ;
        select_time.addEventListener('change' , () => {
            if(select_time.value == "day") {
                revenue.innerHTML = '<div class="row">' +
                                        '@csrf' +
                                        '<div class="form-group col-10">' +
                                            '<input type="hidden" value="day" name="type">' +
                                            '<input type="date" placeholder="Chọn ngày thống kê..." class="form-control" id="myID" name="day">' +
                                        '</div>' +
                                        '<div class="form-group col-2">' +
                                            '<input type="submit" style="background-color:#86B817;color:white;" class="form-control" value="Thống kê">' +
                                        '</div>' +
                                    '</div>' ;
                flatpickr("#myID", {});
            }else if (select_time.value == "month") {
                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();

                let monthSelectHTML = '<select class="form-select" name="month" id="month">';
                for (let i = 1; i <= 12; i++) {
                    monthSelectHTML += `<option value="${i}">Tháng ${i}</option>`;
                }
                monthSelectHTML += '</select>';

                let yearSelectHTML = '<select class="form-select" name="year" id="year">';
                for (let i = 1970; i <= currentYear; i++) {
                    yearSelectHTML += `<option value="${i}">Năm ${i}</option>`;
                }
                yearSelectHTML += '</select>';

                revenue.innerHTML = '<div class="row">' +
                    '@csrf' +
                    '<input type="hidden" value="month" name="type">' +
                    '<div class="form-group col-5">' +
                        monthSelectHTML +
                    '</div>' +
                    '<div class="form-group col-5">' +
                        yearSelectHTML +
                    '</div>' +
                    '<div class="form-group col-2">' +
                        '<input type="submit" style="background-color:#86B817;color:white;" class="form-control" value="Thống kê">' +
                    '</div>' +
                    '</div>';
            }else if(select_time.value == "year") {
                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();

                let yearSelectHTML = '<select class="form-select" name="year" id="year">';
                for (let i = 1970; i <= currentYear; i++) {
                    yearSelectHTML += `<option value="${i}">Năm ${i}</option>`;
                }
                yearSelectHTML += '</select>';

                revenue.innerHTML = '<div class="row">' +
                    '@csrf' +
                    '<input type="hidden" value="year" name="type">' +
                    '<div class="form-group col-10">' +
                        yearSelectHTML +
                    '</div>' +
                    '<div class="form-group col-2">' +
                        '<input type="submit" style="background-color:#86B817;color:white;" class="form-control" value="Thống kê">' +
                    '</div>' +
                    '</div>';
            }else {
                revenue.innerHTML = '' ;
            }
        })
    </script>
@endsection

