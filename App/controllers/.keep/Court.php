<?php
ob_start();

date_default_timezone_set('Asia/Bangkok');

require_once dirname(__FILE__) . "/../config/connectdb.php";

session_start();
$result = new stdClass();
$key = $_POST["key"] !== "" ? $_POST["key"] : null;
if ($key !== null && $key === 'form-add-court') {
    $FormData = $_POST['FormData'];
    unset($FormData['0']);

    $sql_text = "SELECT * FROM `court` WHERE court_name = :court_name AND cout_starus != '0' ";
    $data = [
        ':court_name' => $FormData['court_name']
    ];

    $check_Duplicate = check_Duplicate($sql_text, $data);
    if (!$check_Duplicate->status) :
        $result->msg = "error";
        $result->status_code = 202;
        $result->msg_text = "ระบบตรวจพบข้อมูลซ้ำ!";
        return OutputJson($result);
    endif;



    $dataImage = new stdClass();
    $dataImage->path = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/court/";
    $dataImage->base64_code = $FormData['cout_image'];
    $dataImage = uploadeImageBase64($dataImage);
    if ($dataImage->msg !== 'success') {
        $result->msg = "error";
        $result->status_code = 201;
        $result->msg_text = "เพิ่มคอร์ทไม่สำเร็จ!";
        return OutputJson($result);
    }

    $FormData['cout_image'] = $dataImage->name;


    try {
        // $form = new stdClass();
        $sqlText = "INSERT INTO `court` (`court_id`, `court_name`, `court_type`, `court_price`, `cout_image`, `cout_starus`) 
                                        VALUES (NULL, :court_name, :court_type,:court_price, :cout_image, '1');";

        $data = [
            ':court_name' => $FormData['court_name'],
            ':court_type' => $FormData['court_type'],
            ':court_price' => $FormData['court_price'],
            ':cout_image' => $FormData['cout_image']
        ];


        $queryData = queryData($sqlText, $data);
        if ($queryData->status) :
            $result->msg = "success";
            $result->status_code = 200;
            $result->msg_text = "เพิ่มคอร์ทสำเร็จ!";
            return OutputJson($result);
        else :
            $result->msg = "error";
            $result->status_code = 201;
            $result->msg_text = "เพิ่มคอร์ทไม่สำเร็จ!";
            return OutputJson($result);
        endif;
    } catch (Exception $ex) {
        $result->msg = "error";
        $result->status_code = 500;
        $result->msg_text = "ระบบตรวจพบข้อผิดพลาด ";
        return OutputJson($result);
    }
}



if ($key !== null && $key === 'form-edit-court') {

    $FormData = $_POST['FormData'];
    unset($FormData['0']);
    $tem = DB::query("SELECT * FROM `court` WHERE court_id = {$FormData['court_id']}", PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);

    $sql_text = "SELECT * FROM `court` WHERE court_id != :court_id AND court_name = :court_name   &&  cout_starus != '0' ";
    $data = [
        ':court_id' => $FormData['court_id'],
        ':court_name' => $FormData['court_name']
    ];

    $check_Duplicate = check_Duplicate($sql_text, $data);
    if (!$check_Duplicate->status) :
        $result->msg = "error";
        $result->status_code = 202;
        $result->msg_text = "ระบบตรวจพบข้อมูลซ้ำ!-";
        return OutputJson($result);
    endif;



    $dataImage = new stdClass();
    $dataImage->path = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/court/";
    $dataImage->base64_code = $FormData['cout_image'];

    if (strlen($FormData['cout_image']) > 50) {
        @unlink($dataImage->path  . $tem->cout_image);
        $dataImage = uploadeImageBase64($dataImage);
        $FormData['cout_image'] = $dataImage->name;
    } else {
        $FormData['cout_image'] = $tem->cout_image;
    }




    try {
        // $form = new stdClass();
        $sqlText = "UPDATE `court` SET 
                            `court_name` = :court_name, 
                            `court_type` = :court_type, 
                            `court_price` = :court_price, 
                            `cout_image` = :cout_image 
                            WHERE `court`.`court_id` = {$FormData['court_id']};";

        $data = [
            ':court_name' => $FormData['court_name'],
            ':court_type' => $FormData['court_type'],
            ':court_price' => $FormData['court_price'],
            ':cout_image' => $FormData['cout_image']
        ];


        $queryData = queryData($sqlText, $data);
        if ($queryData->status) :
            $result->msg = "success";
            $result->status_code = 200;
            $result->msg_text = "แก้ไขข้อมูลสำเร็จ!";
            return OutputJson($result);
        else :
            $result->msg = "error";
            $result->status_code = 201;
            $result->msg_text = "แก้ไขข้อมูลไม่สำเร็จ!";
            return OutputJson($result);
        endif;
    } catch (Exception $ex) {
        $result->msg = "error";
        $result->status_code = 500;
        $result->msg_text = "ระบบตรวจพบข้อผิดพลาด ";
        return OutputJson($result);
    }
}




if ($key !== null && $key === 'form-DeletetCourt') {

    $FormData = $_POST['FormData'];
    unset($FormData['0']);
    try {
        if (DB::query("UPDATE `court` SET `cout_starus` = '0' WHERE `court`.`court_id` = {$FormData['curt_id']};")) {
            $result->msg = "success";
            $result->status_code = 200;
            $result->msg_text = "ลบข้อมูลสำเร็จ";
            return OutputJson($result);
        } else {
            $result->msg = "error";
            $result->status_code = 201;
            $result->msg_text = "ลบข้อมูลสำเร็จไม่สำเร็จ!";
            return OutputJson($result);
        }
    } catch (Exception $th) {
        $result->msg = "error";
        $result->status_code = 505;
        $result->msg_text = "ลบข้อมูลสำเร็จไม่สำเร็จ!";
        return OutputJson($result);

    }



}