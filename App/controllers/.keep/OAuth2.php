<?php
ob_start();

date_default_timezone_set('Asia/Bangkok');

require_once dirname(__FILE__) . "/../config/connectdb.php";

session_start();
$result = new stdClass();
$key = $_POST["key"] !== "" ? $_POST["key"] : null;

if ($key !== null && $key === 'form-register') {
    // print_r($_POST['FormData']);
    $FormData = $_POST['FormData'];
    unset($FormData['0']);

    $sql_text = "SELECT * FROM `user` WHERE id_card = :id_card || username = :username   &&  status != 'delete' ";
    $data = [
        'id_card' => $FormData['id_card'],
        'username' => $FormData['username']
    ];

    $check_Duplicate = check_Duplicate($sql_text, $data);
    if (!$check_Duplicate->status) :
        $result->msg = "error";
        $result->status_code = 202;
        $result->msg_text = "ระบบตรวจพบข้อมูลซ้ำ!";
        return OutputJson($result);
    endif;

    $roled = empty($FormData['role']) || $FormData['role'] == 'user' ?  'user' :  'staff';


    try {
        // $form = new stdClass();
        $sqlText = "INSERT INTO `user` (`user_id`, `name`, `username`, `password`, `email`, `phone_number`, `address`, `id_card`, `create_date`, `line_uid`, `status`, `role`) 
                                    VALUES (NULL, :name, :username, :password , :email , :phone_number , NULL, :id_card , current_timestamp(), NULL, 'success', '$roled');";

        $data = [
            ':name' => $FormData['name'],
            ':username' => $FormData['username'],
            ':password' => $FormData['password'],
            ':email' => $FormData['email'],
            ':phone_number' => $FormData['phone_number'],
            ':id_card' => $FormData['id_card']
        ];


        $queryData = queryData($sqlText, $data);
        if ($queryData->status) :
            $result->msg = "success";
            $result->status_code = 200;
            $result->msg_text = "ลงทะเบียนสำเร็จ!";
            return OutputJson($result);
        else :
            $result->msg = "error";
            $result->status_code = 201;
            $result->msg_text = "ลงทะเบียนไม่สำเร็จ!";
            return OutputJson($result);
        endif;
    } catch (Exception $ex) {
        $result->msg = "error";
        $result->status_code = 500;
        $result->msg_text = "ระบบตรวจพบข้อผิดพลาด ";
        return OutputJson($result);
    }
}

if ($key !== null && $key === 'form-login') {
    // print_r($_POST['FormData']);
    $FormData = $_POST['FormData'];
    unset($FormData['0']);


    try {
        // $form = new stdClass();
        $sqlText = "SELECT * FROM `user` WHERE username = '{$FormData['username']}' && password = '{$FormData['password']}' && status != 'delete';";


        $queryData = queryData($sqlText);
        if (empty($queryData->data)) {
            $result->msg = "error";
            $result->status_code = 201;
            $result->msg_text = 'เข้าสู่ระบบไม่สำเร็จ';
            return OutputJson($result);
        }

        if ($queryData->status) :
            $data = $queryData->data[0];

            if ($data->username == $FormData['username'] && $data->password == $FormData['password']) :
                $_SESSION["role"] = $data->role;
                $_SESSION["user_id"] = $data->user_id;

                $result->msg = "success";
                $result->status_code = 200;
                $result->msg_text = 'เข้าสู่ระบบสำเร็จ';
                $result->role = $data->role;
                return OutputJson($result);
            else :
                $result->msg = "error";
                $result->status_code = 201;
                $result->msg_text = 'เข้าสู่ระบบไม่สำเร็จ';
                return OutputJson($result);
            endif;
        else :
            $result->msg = "error";
            $result->status_code = 201;
            $result->msg_text = 'เข้าสู่ระบบไม่สำเร็จ';
            return OutputJson($result);
        endif;
    } catch (Exception $ex) {
        $result->msg = "error";
        $result->status_code = 500;
        $result->msg_text = "ระบบตรวจพบข้อผิดพลาด ";
        return OutputJson($result);
    }
}
