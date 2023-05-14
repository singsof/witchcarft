<?php


require_once __DIR__ . '/../config/connectdb.php';
// require_once __DIR__ . '/../models/Orders.php';
// require_once __DIR__ . '/../models/OrdersDetails.php';
// require_once __DIR__ . '/../models/Payments.php';
require_once __DIR__ . '/../models/TarotCards.php';
require_once __DIR__ . '/../models/RelationCardProducts.php';


$response = new stdClass();
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'addRelationCardButton':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาด หรืออาจชื่อซ้ำ';
                return OutputJson($response);
            }

            $RelationCard = new RelationCardProducts();
            // $RelationCard->setRelation_key();
            $RelationCard->setProduct_key($dataRequest->product_key);
            $RelationCard->setCard_key($dataRequest->card_key);
            $isChck = $RelationCard->insertRelationCardProducts();


            if (!$isChck) {
                $response->msg = "error";
                $response->message = $RelationCard->response;
                return OutputJson($response);
            }


            if ($isChck) {
                $response->msg = "success";
                $response->message = 'เพิ่มข้อมูลสำเร็จ';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message =  $RelationCard->response;;
            return OutputJson($response); //confirmOrderButton
            
            // deleteCardButton
        case 'deletRelationCardButton':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'ไม่สามารถลบข้อมูลได้';
                return OutputJson($response);
            }

            $RelationCard = new RelationCardProducts();
            $RelationCard->setRelation_key($dataRequest->relation_key);
            $isChckDelet = $RelationCard->deleteRelationCardProducts();

            if ($isChckDelet) {
                $response->msg = "success";
                $response->message = 'ลบข้อมูลสำเร็จ';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'ไม่สามารถลบข้อมูลได้';
            return OutputJson($response);
        case '6':
            break;
        default:
            break;
    }
} else {
    // Handle requests without the expected parameters
    // ...
}
