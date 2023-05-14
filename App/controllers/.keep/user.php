<?php
ob_start();

date_default_timezone_set('Asia/Bangkok');

require_once dirname(__FILE__) . "/../config/connectdb.php";

session_start();
$result = new stdClass();
$key = $_POST["key"] !== "" ? $_POST["key"] : null;
if ($key !== null && $key === 'form-edit-about') {

    $FormData = $_POST['FormData'];
    unset($FormData['0']);

    $sql_text = "SELECT * FROM `user` WHERE user_id != :user_id AND (id_card = :id_card || username = :username)   &&  status != 'delete' ";
    $data = [
        'user_id' => $FormData['user_id'],
        'id_card' => $FormData['id_card'],
        'username' => $FormData['username']
    ];

    $check_Duplicate = check_Duplicate($sql_text, $data);
    if (!$check_Duplicate->status):
        $result->msg = "error";
        $result->status_code = 202;
        $result->msg_text = "ระบบตรวจพบข้อมูลซ้ำ!-";
        return OutputJson($result);
    endif;

    try {
        // $form = new stdClass();
        $sqlText = "UPDATE `user` SET 
                        `name` = :name, 
                        `username` = :username, 
                        `password` = :password, 
                        `email` = :email, 
                        `phone_number` = :phone_number, 
                        `address` = :address, 
                        `id_card` = :id_card, 
                        `line_uid` = :line_uid
                    WHERE `user`.`user_id` = {$FormData['user_id']};";

        $data = [
            ':name' => $FormData['name'],
            ':username' => $FormData['username'],
            ':password' => $FormData['password'],
            ':email' => $FormData['email'],
            ':phone_number' => $FormData['phone_number'],
            ':id_card' => $FormData['id_card'],
            ':address' => $FormData['address'], 
            ':line_uid' => $FormData['line_uid']
        ];


        $queryData = queryData($sqlText, $data);
        if ($queryData->status):
            $result->msg = "success";
            $result->status_code = 200;
            $result->msg_text = "แก้ไขข้อมูลสำเร็จ!";
            return OutputJson($result);
        else:
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



if ($key !== null && $key === 'form-DeletetUser') {

    $FormData = $_POST['FormData'];
    unset($FormData['0']);
    try {
        if (DB::query("UPDATE `user` SET `status` = 'delete' WHERE `user`.`user_id` = {$FormData['user_id'] };")) {
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