<?php


require_once __DIR__ . '/../config/connectdb.php';
require_once __DIR__ . '/../models/Orders.php';
require_once __DIR__ . '/../models/OrdersDetails.php';
require_once __DIR__ . '/../models/Payments.php';


$response = new stdClass();
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'cancelOrderButton':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'ไม่สามารถลบข้อมูลได้';
                return OutputJson($response);
            }

            $Orders = new Orders();
            $Orders->setOrder_key($dataRequest->order_key);
            $isChckDelet = $Orders->deleteOrders();

            if ($isChckDelet) {
                $response->msg = "success";
                $response->message = 'ลบข้อมูลสำเร็จ';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'ไม่สามารถลบข้อมูลได้';
            return OutputJson($response); //confirmOrderButton

        case 'pickUpOrderButton':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาด';
                return OutputJson($response);
            }

            $Orders = new Orders();
            $Orders->setOrder_key($dataRequest->order_key);
            $Orders->setOrder_status('success');
            $isChckPickUp = $Orders->updateOrders();

            if ($isChckPickUp) {
                $response->msg = "sending";
                $response->message = 'ยืนยันคำสั่งซื้อ';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'เกิดข้อผิดพลาด';
            return OutputJson($response);


        case 'confirmOrderButton':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาด';
                return OutputJson($response);
            }

            $Orders = new Orders();
            $Orders->setOrder_key($dataRequest->order_key);
            $Orders->setOrder_status('sending');
            $isChckPickUp = $Orders->updateOrders();

            if ($isChckPickUp) {
                $response->msg = "success";
                $response->message = 'รับสินค้าเรียบร้อย';
                return OutputJson($response);
            }

            $response->msg = "error";
            $response->message = 'เกิดข้อผิดพลาด';
            return OutputJson($response);


        case 'form-order':

            $dataRequest = isset($_POST['data']) ? $_POST['data'] : false;
            $dataRequest = json_decode(json_encode($dataRequest));
            if (!$dataRequest) {
                $response->msg = "error";
                $response->message = 'เกินข้อผิดพลาดการสั่งซื้อ';
                return OutputJson($response);
            }

            if ($dataRequest->payment_method === '') {
                $response->msg = "error";
                $response->message = 'กรุณาเลือกรูปแบบการชำระเงิน';
                // return OutputJson($response);
            }
            $productRequest = isset($_POST['product']) ? $_POST['product'] : false;
            $productRequest = json_decode(json_encode($productRequest));

            if (!$productRequest) {
                $response->msg = "error";
                $response->message = 'เกินข้อผิดพลาดการสั่งซื้อ';
                return OutputJson($response);
            }

            $OrdersInser = new Orders();
            $OrdersInser->setOrder_code(20);
            $OrdersInser->setAccount_key($dataRequest->account_id);
            $OrdersInser->setOrder_price($dataRequest->order_price);
            $OrdersInser->setOrder_price_delivery($dataRequest->order_price_delivery);
            $OrdersInser->setOrder_delivery($dataRequest->order_delivery);

            $isCheckInserOrder = $OrdersInser->insertOrders();
            $lastInsertId = DB::lastInsertId();
            if (!$isCheckInserOrder) {
                $response->msg = "error";
                $response->message = 'เกินข้อผิดพลาดการสั่งซื้อ';
                return OutputJson($response);
            }

            foreach ($productRequest as $key => $item) {
                $OrderDetails_insert = new OrderDetails();
                $OrderDetails_insert->setOrder_key($lastInsertId);
                $OrderDetails_insert->setProduct_key($item->product_key);
                $OrderDetails_insert->setOrdetail_price($item->product_price);
                $OrderDetails_insert->setOrdetail_item($item->ordetail_item);
                $isChckInsertDetail = $OrderDetails_insert->insertOrderDetails();

                if (!$isChckInsertDetail) {
                    $response->msg = "error";
                    $response->message = 'เกินข้อผิดพลาดการสั่งซื้อ';
                    return OutputJson($response);
                }
            }

            $cashAll = $dataRequest->order_price + $dataRequest->order_price_delivery;
            $paymentInser = new Payments();
            $paymentInser->setOrder_key($lastInsertId);
            $paymentInser->setPayment_amount($cashAll);
            $paymentInser->setPayment_method($dataRequest->payment_method);
            $isChckPaymentInser = $paymentInser->insertPayments();

            if (!$isChckPaymentInser) {
                $response->msg = "error";
                $response->message = 'เกิดข้อผิดพลาดการชำระเงิน';
                return OutputJson($response);
            }

            $response->msg = "success";
            $response->message = 'สั่งซื้อสินค้าสำเร็จ';
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
