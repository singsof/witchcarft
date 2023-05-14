<?php
ob_start();

date_default_timezone_set('Asia/Bangkok');

session_start();
require_once dirname(__FILE__) . "/../config/connectdb.php";



// FormData
$court_id = $_POST["court_id"];
$date = $_POST["date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$total_price = $_POST["total_price"];
$user_id = $_POST["user_id"];
$check = null;


$dateN = date('Y-m-d');
$TimeN = date('H:i', strtotime('+60 minutes'));
// $TimeEP = date('H:i', strtotime('+100 minutes'));

// $da = new DateTime($dateN);
// print_r($da->format('H:i:s'));

// $datetime1 = new DateTime('01/01/2021 10:00 AM');
// $datetime2 = new DateTime("$date $start_time");

$datetimeRever = new DateTime("$date $start_time");
$datetimeNow = new DateTime("$dateN $TimeN");


if ($datetimeRever < $datetimeNow) {
    echo "<script> alert('กรุณาจองก่อนเวลา 1 ชั่วโมง') ; window.history.back(-1) </script>";
    return 0;
}


// ตรวจสอบรายการซ้ำ
$sqlTextChck = "SELECT * FROM `reservation` WHERE 
                                user_id = '$user_id' AND 
                                court_id = '$court_id' AND 
                                reservation_date = '$date' AND 
                                start_time = '$start_time'  AND 
                                end_time = '$end_time'  AND  
                                ref_status != 0 ";
$check_Duplicate = check_Duplicate($sqlTextChck);
if (!$check_Duplicate->status) :
    echo "<script> alert('ระบบตรวจพบรายการซ้ำ กรุณาตรวจสอบใหม่อีกครั้ง') ; window.history.back(-1) </script>";
    return 0;
endif;

$role = $_SESSION["role"];
$goLink = $role == 'user' ? 'default' : $role;
$statusPlayment = false;

if (isset($_POST['submit'])) {
    $sqlText = "INSERT INTO `reservation` (`reservation_id`, `user_id`, `court_id`, `reservation_date`, `start_time`, `end_time`, `total_price`,`ref_status`) 
                            VALUES (NULL, '$user_id', '$court_id', '{$_POST["date"]}', '$start_time', '$end_time', '$total_price','4');";
    $tem = DB::prepare($sqlText);
    $tem->execute();


    $id = DB::query("SELECT * FROM `reservation` ORDER BY `reservation`.`reservation_id` DESC",PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ)->reservation_id;

    // $id = DB::lastInsertId();


    try {
        $response = $gateway->purchase(array(
            'amount' => $_POST['amount'],
            'currency' => $_ENV['PAYPAL_CURRENCY'],
            'returnUrl' => "http://badminton.swsoft.com/App/controllers/success_paypal.php?id=$id&price=$total_price",
            'cancelUrl' => "http://badminton.swsoft.com/view/$goLink/property-list.php?date=$date&time-start=$start_time&time-end=$end_time",
        ))->send();

        if ($response->isRedirect()) {
            $statusPlayment = true;

            $response->redirect(); // this will automatically forward the customer
        } else {
            // not successful
            echo $response->getMessage();
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
