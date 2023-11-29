<?php
include("../connect/connect.php");
//link github momo : https://github.com/momo-wallet/payment/tree/master/php
header('Content-type: text/html; charset=utf-8');

//MOMO
//thông tin test: https://developers.momo.vn/v3/vi/docs/payment/onboarding/test-instructions
// lin: https://github.com/momo-wallet/payment/blob/master/php/atm/atm_momo.php
/**
 *NGUYEN VAN A
 *9704 0000 0000 0018
 *03/07
 *OTP
 */
session_start();
function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}
global $connect;

if (isset($_POST['payUrl'])) {
    
    //Cài đặt thông tin cổng thanh toán Momo
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";   //thiết lập cổng thanh toán momo -> bản thử nghiệm
    $partnerCode = 'MOMOBKUN20180529'; 
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa'; 

    //Lấy và xử lý thông tin đơn hàng từ biểu mẫu:
    $orderInfo = "Thanh toán qua MoMo";
    $amountString = $_POST['cart-total-price'];
    $amountConvert = strval($amountString);
    $amountInt = str_replace(array('.', 'đ'), '', $amountConvert);
    $amount = intval($amountInt);
    $orderId = rand(00, 9999) . "";
    $redirectUrl = "http://localhost/ecommerce/layout_user/homepage.php";
    $ipnUrl = "http://localhost/ecommerce/layout_user/homepage.php";
    $extraData = "";
    if (!empty($redirectUrl)) {
        global $connect;
        $email = $_SESSION['email'];
        $cart_query = "select * from `cart` where email = '$email'";
        $order_status = 'Đã thanh toán';
        $user_id = $_SESSION['id'];
        $name_orders = $_SESSION['name'];
        $phone_orders = $_SESSION['phone'];
        $address_orders = $_SESSION['address'];
        $total_cart_query = "select quantity FROM cart WHERE email = '$email'";
        $total_cart_result = mysqli_query($connect, $total_cart_query);
        if ($total_cart_result) {
            $row = mysqli_fetch_assoc($total_cart_result);
            $total_cart = $row['quantity'];
            $insert_query = "insert into `orders` (user_id,total_products,order_status,name_orders,phone_orders,address_orders,email) values 
        ($user_id, $total_cart , '$order_status','$name_orders','$phone_orders','$address_orders','$email')";
            $result = mysqli_query($connect, $insert_query);
            if ($result) {
                $truncate_cart = "delete from cart where email ='$email'";
                $truncate_query = mysqli_query($connect, $truncate_cart);

                if ($truncate_query) {
                    echo "<script>alert('Order success')</script>";
                } else {
                    echo "<script>alert('Error truncating cart')</script>";
                }
            } else {
                echo "<script>alert('Error inserting order')</script>";
            }

        }

    }


    $requestId = time() . "";
    $requestType = "payWithATM";
    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //before sign HMAC SHA256 signature
    //Tạo chữ ký cho yêu cầu MoMo bằng HMAC SHA256:
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    //Chuẩn bị dữ liệu cho yêu cầu API MoMo:
    $data = array(
        'partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature
    );

    //Gửi yêu cầu POST đến API MoMo và chuyển hướng người dùng đến URL thanh toán:
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true); // decode json
    //Just a example, please check more in there

    header('Location: ' . $jsonResult['payUrl']);
} else {
    echo '22';
    var_dump(strval(1350000));
}



?>