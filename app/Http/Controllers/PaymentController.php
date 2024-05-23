<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    // Thanh toán vnpay ;
    public function payVnPay(Request $request) {
        // Lấy thông tin đơn đặt phòng ;

        $reservation_id = $request->reservation_id ;

        $reservation = Reservation::where('id' , $reservation_id)->first() ;

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/bookingHotel/public/history-booking";
        
        $vnp_TmnCode = "7JGVXU97";//Mã website tại VNPAY 
        $vnp_HashSecret = "BEK5YE52QW00BWCOIIE915VTYYLNAIP1"; //Chuỗi bí mật
        
        $vnp_TxnRef = rand(100000000 , 999999999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán đơn đặt phòng";
        $vnp_OrderType = "Thanh toán online";
        $vnp_Amount = $reservation->total_amount * 100 ;
        $vnp_Locale = "VN";
        $vnp_BankCode = "";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            // "vnp_ExpireDate"=> $vnp_ExpireDate ,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
        if (isset($_POST['redirect'])) {
            Session::put('reservation_id' , $reservation_id) ;
            Session::put('$vnp_TxnRef' , $vnp_TxnRef) ;
            return redirect($vnp_Url) ;
        } else {
            echo json_encode($returnData);
        }
    
    }

    
    //  Thanh toán bằng momo ;
    // public function execPostRequest($url, $data)
    // {
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt(
    //         $ch,
    //         CURLOPT_HTTPHEADER,
    //         array(
    //             'Content-Type: application/json',
    //             'Content-Length: ' . strlen($data)
    //         )
    //     );
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    //     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //     //execute post
    //     $result = curl_exec($ch);
    //     //close connection
    //     curl_close($ch);
    //     return $result;
    // }
    // public function atmMomo(Request $request) {

    //     // Lấy id đơn đặt phòng ;

    //     $reservation_id = $request->reservation_id ;

    //     $reservation = Reservation::where('id' , $reservation_id)->first() ;

    //     $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    //     $partnerCode = 'MOMOBKUN20180529';
    //     $accessKey = 'klm05TvNBzhg7h7j';
    //     $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    //     $orderInfo = "Thanh toán qua ATM MoMo";
    //     $amount = $reservation->total_amount;
    //     $orderId = time() ."";
    //     $redirectUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
    //     $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
    //     $extraData = "";


    //     $requestId = time() . "";
    //     $requestType = "payWithATM";
    //     //before sign HMAC SHA256 signature
    //     $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    //     $signature = hash_hmac("sha256", $rawHash, $secretKey);
    //     $data = array('partnerCode' => $partnerCode,
    //         'partnerName' => "Test",
    //         "storeId" => "MomoTestStore",
    //         'requestId' => $requestId,
    //         'amount' => $amount,
    //         'orderId' => $orderId,
    //         'orderInfo' => $orderInfo,
    //         'redirectUrl' => $redirectUrl,
    //         'ipnUrl' => $ipnUrl,
    //         'lang' => 'vi',
    //         'extraData' => $extraData,
    //         'requestType' => $requestType,
    //         'signature' => $signature);
    //     $result = $this->execPostRequest($endpoint, json_encode($data));

    //     $jsonResult = json_decode($result, true);  // decode json

    //     return redirect()->to($jsonResult['payUrl']) ;
    // }
}
