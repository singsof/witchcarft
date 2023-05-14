<?php
ob_start();

date_default_timezone_set('Asia/Bangkok');

session_start();
require_once dirname(__FILE__) . "/../config/connectdb.php";
// // define('OMISE_API_VERSION', '2015-11-17');
define('OMISE_API_VERSION', "2019-05-29");

define('OMISE_PUBLIC_KEY', $_ENV['OMISE_PUBLIC_KEY']);
define('OMISE_SECRET_KEY',  $_ENV['OMISE_SECRET_KEY']);

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

// 2023-03-20 03:13 - 17:02
// var_dump($datetimeRever < $datetimeNow);




if ($datetimeRever < $datetimeNow) {
    echo "<script> alert('กรุณาจองก่อนเวลา 1 ชั่วโมง') ; window.history.back(-1) </script>";
    return 0;
}
// else if ($dateN == $date) {
//     if ($start_time  >= $TimeN) {
//         echo "<script> alert('ไม่สามารถใช้เวลานี้ได้  $date $TimeN - $start_time') ; window.history.back(-1) </script>";
//         return 0;
//     }
// }

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


$charge = OmiseCharge::create(array(
    'amount' => $_POST["price"],
    'currency' => 'THB',
    'card' => $_POST["omiseToken"]
));

$check = $charge['status'];

if ($check == 'successful') :

    $sqlText = "INSERT INTO `reservation` (`reservation_id`, `user_id`, `court_id`, `reservation_date`, `start_time`, `end_time`, `total_price`) 
                                        VALUES (NULL, '$user_id', '$court_id', '{$_POST["date"]}', '$start_time', '$end_time', '$total_price');";
    $tem = DB::prepare($sqlText);
    if ($tem->execute()) :
        $id = DB::lastInsertId();

        $sqlText_1 = "INSERT INTO `payment` (`payment_id`, `reservation_id`, `payment_date`, `payment_method`, `payment_amount`) 
                                            VALUES (NULL, '$id', current_timestamp() , 'บัตรเคดิต', '$total_price');";
        $tem_1 = DB::prepare($sqlText_1);
        if ($tem_1->execute()) :
            if ($check == 'successful') :
?>
                <script>
                    alert("ชำระเงินสำเร็จ")
                    window.location.assign('/view/<?php echo $role == 'user' ? 'default' : $role ?>/list-order.php')
                </script>
            <?php else : ?>
                <script>
                    alert("ไม่สามารถชำระเงินได้")
                    window.history.back(-1)
                </script>
            <?php endif; ?>
<?php
        endif;
    endif;
endif; ?>