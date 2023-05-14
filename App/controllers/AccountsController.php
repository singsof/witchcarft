<?php
ob_start();



require_once __DIR__ . '/../config/connectdb.php';
require_once __DIR__ . '/../models/Accounts.php';

class AccountsController
{
    public function login($account_email, $account_password)
    {
        $accountLoin = new Accounts();
        $accountLoin->setAccount_email($account_email);
        $accountLoin->setAccount_password($account_password);

        return $accountLoin->verifyAccountLogin();
    }
}








$accountController = new AccountsController();
// Check the value of a parameter to determine which method to call
$response = new stdClass();


if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'form-login':
            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            unset($dataRequest['0']);
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'เข้าสู่ระบบไม่สำเร็จ';
                return OutputJson($response);
            }

            $accountLoin = new Accounts();
            $accountLoin->setAccount_email($dataRequest->account_email);
            $accountLoin->setAccount_passwordNoHash($dataRequest->account_password);

            $verifyLogin = $accountLoin->verifyAccountLogin();
            $accountData = $accountLoin->response;
            // return OutputJson($accountData);

            if ($verifyLogin) {
                $_SESSION["account_role"] = $accountData->account_role;
                $_SESSION["account_id"] = $accountData->account_id;

                $response->msg = "success";
                $response->message = 'เข้าสู่ระบบสำเร็จ';

                $response->role = $accountData->account_role;
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'เข้าสู่ระบบไม่สำเร็จ';


            return OutputJson($accountData);


        case 'form-register':
            // $controller->handleAjaxRequest2();
            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            unset($dataRequest['0']);
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'เข้าสู่ระบบไม่สำเร็จ';
                return OutputJson($response);
            }

            $accountRegister = new Accounts();
            $accountRegister->setAccount_name($dataRequest->account_name);
            $accountRegister->setAccount_phone($dataRequest->account_phone);
            $accountRegister->setAccount_email($dataRequest->account_email);
            $accountRegister->setAccount_password($dataRequest->account_password);
            $accountRegister->setAccount_address($dataRequest->account_address);


            $isCheckRegister = $accountRegister->insertAccounts();
            if ($isCheckRegister) {
                $response->msg = "success";
                $response->message = 'สมัครสมาชิกสำเร็จ';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'สมัครสมาชิกไม่สำเร็จ';
            OutputJson($response);
            break;

        case 'edit-about-form':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            unset($dataRequest['0']);
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'ไม่สามารถแก้ไขข้อมูลได้';
                return OutputJson($response);
            }

            $accountGetData = new Accounts();
            $accountGetData->getShowAccountsOne($dataRequest->account_id);


            $accountUpdate = new Accounts();
            $accountUpdate->setAccount_id($dataRequest->account_id);
            $accountUpdate->setAccount_name($dataRequest->account_name);
            $accountUpdate->setAccount_email($dataRequest->account_email);

            if ($dataRequest->account_password == '') {
                $accountUpdate->setAccount_passwordNoHash($accountGetData->getAccount_password());
            } else {
                $accountUpdate->setAccount_password($dataRequest->account_password);
            }

            $accountUpdate->setAccount_phone($dataRequest->account_phone);
            $accountUpdate->setAccount_address($dataRequest->account_address);


            $isChckUpdate =  $accountUpdate->updateAccounts();


            if($isChckUpdate){
                $response->msg = "success";
                $response->message = 'แก้ไขข้อมูลสำเร็จ';
                return OutputJson($response);
            }
            $response->msg = "error";
            $response->message = 'ไม่สามารถแก้ไขข้อมูลได้';
            return OutputJson($response);
        case '4':
            break;
        case '5':
            break;
        case '6':
            break;
        default:
            break;
    }
} else {
    // Handle requests without the expected parameters
    // ...
}
