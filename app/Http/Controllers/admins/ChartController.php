<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\Chart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ChartController extends Controller
{
    protected $charts ;

    public function __construct() {
        $this->charts = new Chart() ;
    }

    // Thống kê doanh thu ;

    public function chartRevenue() {

        $title = "Thống kê doanh thu" ;

        $resultRevenue = $this->charts->chartRevenue("" , "") ;

        if(session()->has('revenue')) {
            $title = session('title') ;
            $resultRevenue = session('revenue') ;
        }

        return view('admins.charts.chart_revenue' , compact('title' , 'resultRevenue')) ;
    }

    public function resultRevenue(Request $request) {

        $type = $request->type ;

        if($type == "day") {

            $time = $request->day ;

            $resultRevenue = $this->charts->chartRevenue($type , $time) ;

            $format_time = date("d-m-Y", strtotime($time));

            return Redirect::route('chart-revenue')->with(['revenue' => $resultRevenue , 'title' => "Thống kê doanh thu ngày " .$format_time]) ;
        }else if ($type == "month") {

            if($request->month < 10) {
                $month = 0 .$request->month ;
            }else {
                $month = $request->month ;
            }

            $year = $request->year ;

            $time = $year . '-' .$month ;

            $resultRevenue = $this->charts->chartRevenue($type , $time) ;

            $format_time = date("m-Y", strtotime($time));

            return Redirect::route('chart-revenue')->with(['revenue' => $resultRevenue , 'title' => 'Thống kê doanh thu tháng ' .$format_time]) ;
        }else {

            $type = $request->type ;

            $time = $request->year ;

            $resultRevenue = $this->charts->chartRevenue($type , $time) ;

            return Redirect::route('chart-revenue')->with(['revenue' => $resultRevenue , 'title' => 'Thống kê doanh thu năm ' .$time]) ;
        }
    }


    // Thống kê tổng số lượt đặt phòng ;

    public function chartBooking() {

        $title = "Thống kê lượt đặt phòng" ;

        $resultBookings = $this->charts->chartBookings("" , "") ;

        if(session()->has('bookings')) {
            $title = session('title') ;
            $resultBookings = session('bookings') ;
        }

        return view('admins.charts.chart_booking' , compact('title' , 'resultBookings')) ;
    }

    public function resultBooking(Request $request) {

        $type = $request->type ;

        if($type == "day") {

            $time = $request->day ;

            $resultBookings = $this->charts->chartBookings($type , $time) ;

            $format_time = date("d-m-Y", strtotime($time));

            return Redirect::route('chart-bookings')->with(['bookings' => $resultBookings , 'title' => "Thống kê lượt đặt phòng ngày " .$format_time]) ;
        }else if ($type == "month") {

            if($request->month < 10) {
                $month = 0 .$request->month ;
            }else {
                $month = $request->month ;
            }

            $year = $request->year ;

            $time = $year . '-' .$month ;

            $resultBookings = $this->charts->chartBookings($type , $time) ;

            $format_time = date("m-Y", strtotime($time));

            return Redirect::route('chart-bookings')->with(['bookings' => $resultBookings , 'title' => 'Thống kê lượt đặt phòng tháng ' .$format_time]) ;
        }else {

            $type = $request->type ;

            $time = $request->year ;

            $resultBookings = $this->charts->chartBookings($type , $time) ;

            return Redirect::route('chart-bookings')->with(['bookings' => $resultBookings , 'title' => 'Thống kê lượt đặt phòng năm ' .$time]) ;
        }
    }
}
