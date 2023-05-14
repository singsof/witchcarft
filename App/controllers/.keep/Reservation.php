<?php
ob_start();

date_default_timezone_set('Asia/Bangkok');

require_once dirname(__FILE__) . "/../config/connectdb.php";

session_start();
$result = new stdClass();
$key = $_POST["key"] !== "" ? $_POST["key"] : null;
if ($key !== null && $key === 'form-cancelReservation') {

    $FormData = $_POST['FormData'];
    unset($FormData['0']);



    $reservation_id = $FormData['reservation_id'];

    $resultDB = DB::query("SELECT * FROM `reservation` WHERE reservation_id = '$reservation_id'", PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);

    $date = $resultDB->reservation_date;
    $start_time = $resultDB->start_time;
    $dateN = date('Y-m-d');
    $TimeN = date('H:i', strtotime('+60 minutes'));
    $datetimeRever = new DateTime("$date $start_time");
    $datetimeNow = new DateTime("$dateN $TimeN");


    $role = $_SESSION["role"];


    if ($datetimeRever < $datetimeNow && $role == "user") {
        $result->msg = "error";
        $result->status_code = 201;
        $result->msg_text = "กรุณายกเลิก ก่อน 60 นาที!";
        return OutputJson($result);
    }


    try {
        if (DB::query("UPDATE `reservation` SET `ref_status` = '0' WHERE `reservation`.`reservation_id` = {$reservation_id};")) {
            $result->msg = "success";
            $result->status_code = 200;
            $result->msg_text = "ยกเลิกการจองสำเร็จ";
            return OutputJson($result);
        } else {
            $result->msg = "error";
            $result->status_code = 201;
            $result->msg_text = "ยกเลิกการจองไม่สำเร็จ!";
            return OutputJson($result);
        }
    } catch (Exception $th) {
        $result->msg = "error";
        $result->status_code = 505;
        $result->msg_text = "ยกเลิกการจองไม่สำเร็จ!";
        return OutputJson($result);
    }
}


if ($key !== null && $key === 'form-successReservation') {

    $FormData = $_POST['FormData'];
    unset($FormData['0']);
    try {
        if (DB::query("UPDATE `reservation` SET `ref_status` = '3' WHERE `reservation`.`reservation_id` = {$FormData['reservation_id']};")) {
            $result->msg = "success";
            $result->status_code = 200;
            $result->msg_text = "ยืนยันออกจากร้าน";
            return OutputJson($result);
        } else {
            $result->msg = "error";
            $result->status_code = 201;
            $result->msg_text = "ยืนยันออกจากร้านไม่สำเร็จ!";
            return OutputJson($result);
        }
    } catch (Exception $th) {
        $result->msg = "error";
        $result->status_code = 505;
        $result->msg_text = "ยืนยันออกจากร้านไม่สำเร็จ!";
        return OutputJson($result);
    }
}


// form-startINCourt


if ($key !== null && $key === 'form-startINCourt') {

    $FormData = $_POST['FormData'];
    unset($FormData['0']);
    try {
        if (DB::query("UPDATE `reservation` SET `ref_status` = '2' WHERE `reservation`.`reservation_id` = {$FormData['reservation_id']};")) {
            $result->msg = "success";
            $result->status_code = 200;
            $result->msg_text = "ยืนยันเข้าใช้งานสำเร็จ";
            return OutputJson($result);
        } else {
            $result->msg = "error";
            $result->status_code = 201;
            $result->msg_text = "ยืนยันเข้าใช้งานสำเร็จไม่สำเร็จ!";
            return OutputJson($result);
        }
    } catch (Exception $th) {
        $result->msg = "error";
        $result->status_code = 505;
        $result->msg_text = "ยืนยันเข้าใช้งานสำเร็จไม่สำเร็จ!";
        return OutputJson($result);
    }
}
