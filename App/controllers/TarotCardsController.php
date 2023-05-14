<?php


require_once __DIR__ . '/../config/connectdb.php';
// require_once __DIR__ . '/../models/Orders.php';
// require_once __DIR__ . '/../models/OrdersDetails.php';
// require_once __DIR__ . '/../models/Payments.php';
require_once __DIR__ . '/../models/TarotCards.php';


$response = new stdClass();
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'editTarotcards_form':
            // echo 'Edit Tarotcards';
            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาด';
                return OutputJson($response);
            }

            
            $TarotCards = new TarotCards();
            $TarotCards->setCard_key($dataRequest->card_key_EditTaro);
            $TarotCards->setCard_name($dataRequest->card_name_EditTaro);
            $TarotCards->setCard_meaning($dataRequest->card_meaning_EditTaro);
            $TarotCards->setCard_detail($dataRequest->card_detail_EditTaro);

            $taroData = new TarotCards();
            $taroData->setCard_key($dataRequest->card_key_EditTaro);
           

            if (strlen($dataRequest->card_picture_EditTaro) > 50) {
                $isChck = $TarotCards->uploadeImage('./../../view/assets/images/tarotcards/', $dataRequest->card_picture_EditTaro);
                $TarotCards->setCard_picture($TarotCards->getImageName());
            } else {

                $TarotCards->setCard_picture($taroData->getCard_picture());
                $isChck = true;
            }


            

            if (!$isChck) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาด';
                return OutputJson($response);
            }


            $isChck = $TarotCards->updateTarotCards();

            // return $TarotCards;
            if ($isChck) {
                $response->msg = "success";
                $response->message = 'อัพเดตข้อมูลสำเร็จ';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'เกิดข้อผิดพลาด ';
            return OutputJson($response); //confirmOrderButton
            // break;
        case 'addProduct-form':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาด หรืออาจชื่อซ้ำ';
                return OutputJson($response);
            }

            $TarotCards = new TarotCards();
            $TarotCards->setCard_name($dataRequest->card_name);
            $TarotCards->setCard_meaning($dataRequest->card_meaning);
            $TarotCards->setCard_detail($dataRequest->card_detail);

            if ($dataRequest->card_picture != '') {
                $response->msg = "error";
                $response->message = 'กรุณาเพิ่มรูปภาพ';
                return OutputJson($response);
            }
            
            $isChck = $TarotCards->uploadeImage('./../../view/assets/images/tarotcards/', $dataRequest->card_picture);

            if (!$isChck) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาด หรืออาจชื่อซ้ำ';
                return OutputJson($response);
            }

            $TarotCards->setCard_picture($TarotCards->getImageName());

            $isChck = $TarotCards->insertTarotCards();

            if ($isChck) {
                $response->msg = "success";
                $response->message = 'เพิ่มข้อมูลสำเร็จ';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'เกิดข้อผิดพลาด หรืออาจชื่อซ้ำ';
            return OutputJson($response); //confirmOrderButton
            // 
            // deleteCardButton
        case 'deleteCardButton':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'ไม่สามารถลบข้อมูลได้';
                return OutputJson($response);
            }

            $TarotCards = new TarotCards();
            $TarotCards->setCard_key($dataRequest->card_key);
            $isChckDelet = $TarotCards->deleteTarotCards();

            if ($isChckDelet) {
                $response->msg = "success";
                $response->message = 'ลบข้อมูลสำเร็จ';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'ไม่สามารถลบข้อมูลได้';
            return OutputJson($response); //confirmOrderButton
        case '6':
            break;
        default:
            break;
    }
} else {
    // Handle requests without the expected parameters
    // ...
}
