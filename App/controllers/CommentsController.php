<?php 



require_once __DIR__ . '/../config/connectdb.php';
require_once __DIR__ . '/../models/Comments.php';


$response = new stdClass();
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'form-comment':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'ไม่สามารถลบข้อมูลได้';
                return OutputJson($response);
            }

            $Comments = new Comments();
            $Comments->setaccount_key($dataRequest->account_id);
            $Comments->setComment_detail($dataRequest->comment_detail);
            $Comments->setComment_title($dataRequest->comment_title);
            $Comments->setProduct_key($dataRequest->product_key);

            $isChckInset = $Comments->insertComments();

            if($isChckInset){
                $response->msg = "success";
                $response->message = 'โพสต์คอมเมนต์สำเร็จ';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'ไม่สามารถโพสต์คอมเมนต์ได้';
            return OutputJson($response);
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
