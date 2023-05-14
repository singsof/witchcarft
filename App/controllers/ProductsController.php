<?php


require_once __DIR__ . '/../config/connectdb.php';
// require_once __DIR__ . '/../models/Orders.php';
// require_once __DIR__ . '/../models/OrdersDetails.php';
// require_once __DIR__ . '/../models/Payments.php';
// require_once __DIR__ . '/../models/Products.php';
require_once __DIR__ . '/../models/Products.php';
require_once __DIR__ . '/../models/RelationCardProducts.php';


$response = new stdClass();
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'editProducts_form':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาด';
                return OutputJson($response);
            }

            
            $Products = new Products();
            $Products->setProduct_key($dataRequest->card_key_EditTaro);
            $Products->setProduct_name($dataRequest->card_name_EditTaro);
            $Products->setProduct_stock($dataRequest->card_meaning_EditTaro);
            $Products->setProduct_price($dataRequest->card_meaning_EditTaro);
            $Products->setProduct_detail($dataRequest->card_detail_EditTaro);

            $producData = new Products();
            $producData->setProduct_key($dataRequest->card_key_EditTaro);
           

            if (strlen($dataRequest->card_picture_EditTaro) > 50) {
                $isChck = $Products->uploadeImage('./../../view/assets/images/Products/', $dataRequest->card_picture_EditTaro);
                $Products->setProduct_picture($Products->getImageName());
            } else {

                $Products->setProduct_picture($producData->getProduct_picture());
                $isChck = true;
            }

            if (!$isChck) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาด';
                return OutputJson($response);
            }


            $isChck = $Products->updateProducts();

            // return $Products;
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

            $Products = new Products();
            $Products->setProduct_name($dataRequest->product_name);
            $Products->setProduct_price($dataRequest->product_price);
            $Products->setProduct_stock($dataRequest->product_stock);
            $Products->setProduct_detail($dataRequest->product_detail);


            
            if (strlen($dataRequest->product_picture) == 0) {
                $response->msg = "error";
                $response->message = 'กรุณาเพิ่มรูปภาพ';
                return OutputJson($response);
            }



            $isChck = $Products->uploadeImage('./../../view/assets/images/Products/', $dataRequest->product_picture);



            if (!$isChck) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาด ';
                return OutputJson($response);
            }

            $Products->setProduct_picture($Products->getImageName());

            $isChckx = $Products->insertProducts();

            // return OutputJson($Products->response);

            if ($isChckx) {
                $response->msg = "success";
                $response->message = 'เพิ่มข้อมูลสำเร็จ';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'เกิดข้อผิดพลาด ';
            return OutputJson($response); //confirmOrderButton
            // 
            // deleteCardButton
        case 'deleteProductButton':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'ไม่สามารถลบข้อมูลได้';
                return OutputJson($response);
            }

            $Products = new Products();
            $Products->setProduct_key($dataRequest->product_key);
            $isChckDelet = $Products->deleteProducts();

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
