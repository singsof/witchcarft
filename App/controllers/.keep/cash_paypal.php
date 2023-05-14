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
$status = $_POST["status"] == 'true' ? '1' : '4';
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
                                -- ((reservation.start_time >= '$start_time' AND reservation.end_time < '$start_time') OR 
                                -- (reservation.start_time > '$end_time' AND reservation.end_time <= '$end_time'))
                                -- start_time = '$start_time'  AND 
                                -- end_time = '$end_time'  AND  
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
                            VALUES (NULL, '$user_id', '$court_id', '{$_POST["date"]}', '$start_time', '$end_time', '$total_price','$status');";
    $tem = DB::prepare($sqlText);
    if ($tem->execute()) :

        $reservation = DB::query("SELECT * FROM `reservation` ORDER BY `reservation`.`reservation_id` DESC", PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);

        $sqlText_1 = "INSERT INTO `payment` (`payment_id`, `reservation_id`, `payment_date`, `payment_method`, `payment_amount`) 
                                            VALUES (NULL, '$reservation->reservation_id', current_timestamp() , 'cash', '$reservation->total_price');";
        $tem_1 = DB::prepare($sqlText_1);
        $tem_1->execute()
?>
        <script>
            alert("จองสำเร็จ")
            window.location.assign('/view/<?php echo $goLink ?>/list-order.php')
        </script>

    <?php
    else :
    ?>
        <script>
            alert("ไม่สามารถจองได้")
            window.history.back(-1)
        </script>

<?php
    endif;
    // $id = DB::query("SELECT * FROM `reservation` ORDER BY `reservation`.`reservation_id` DESC",PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ)->reservation_id;

    // $id = DB::lastInsertId();



}
